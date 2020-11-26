$(document).ready(function () {
	function effect_msg() {
		// $('.msg-alert').hide();
		$(".msg-alert").show(500);
		setTimeout(function () {
			$(".msg-alert").slideUp(500);
		}, 5000);
	}

	showCategoryData();

	function showCategoryData() {
		var url = new URL("http://localhost/ecommerce-base/");

		$.ajax({
			type: "GET",
			url: url.pathname + "get-data-category",
			dataType: "JSON",
			success: function (data) {
				var category =
					'<li><a href="' +
					url.pathname +
					'product-section">All Product</a></li>';
				var i;

				for (i = 0; i < data.length; i++) {
					category +=
						'<li><a href="' +
						url.pathname +
						"product-section-category/" +
						data[i].category_name +
						'">' +
						data[i].category_name +
						"</a></li>";
				}

				$("#show-data-category").html(category);
			},
		});
	}

	$(".depart-hover").on("shown.bs.tab", function (e) {
		$(".active").attr("data-value");
	});

	$("li#cart-icon").removeClass("active");
});

showShoppingCart();
showDetailCart();
/* getCheckOutBilling(); */
getCheckOutOrder();
getCheckCompanyChargeValue();
getCompanyFullAddress();

function setShoppingCart(id) {
	c;
	var url = new URL("http://localhost/ecommerce-base/");

	var qty = 1;
	$.ajax({
		url: url.pathname + "set-shopping-cart/" + id,
		type: "POST",
		data: {
			qty: qty,
		},
		dataType: "JSON",
		success: function (data) {
			if (data.auth_status == true) {
				Swal.fire({
					title: "Sorry, you need to sign in!",
					icon: "warning",
					showCancelButton: true,
					confirmButtonColor: "#3085d6",
					cancelButtonColor: "#d33",
					confirmButtonText: "Yes, sign in!",
				}).then((result) => {
					if (result.value) {
						location.href = url.pathname + "sign-in";
					}
				});
			} else {
				if (data.insert_status == true) {
					Swal.fire({
						icon: "success",
						title: "Successfully added to your shopping cart!",
						showConfirmButton: false,
						timer: 5000,
					});
				}

				if (data.update_status == true) {
					Swal.fire({
						icon: "success",
						title: "Successfully updated from your shopping cart!",
						showConfirmButton: false,
						timer: 5000,
					});
				}

				showShoppingCart();
			}
		},
	});
}

function showShoppingCart() {
	var url = new URL("http://localhost/ecommerce-base/");

	$.ajax({
		url: url.pathname + "get-shopping-cart",
		type: "GET",
		dataType: "JSON",
		success: function (data) {
			if (data.count_rows > 0) {
				$(".cart-hover").show();
			} else {
				$(".cart-hover").hide();
			}

			$("#show_count_cart").html(data.count_rows);

			$("#show_shopping_cart").html(data.shopping_cart);
			$("#total-cart").html("<h5>" + data.price + "</h5>");
			$(".cart-price").html(data.price);
		},
		error: function (jqXHR, textStatus, errorThrown) {
			Swal.fire({
				icon: "error",
				title: textStatus,
				showConfirmButton: false,
				timer: 5000,
			});
		},
	});
}

function numberFormat(element) {
	element.value = element.value.replace(/[^0-9]+/g, "");
}

function showDetailCart() {
	var url = new URL("http://localhost/ecommerce-base/");

	$.ajax({
		url: url.pathname + "get-detail-shopping-cart",
		type: "GET",
		dataType: "JSON",
		success: function (data) {
			// $('#qty_val').val(data.qty);
			// $('.quantity #pro-qty').addClass('pro-qty');
			$("#show-detail-shopping-cart").html(data.html);

			subAmount();
		},
		/* error: function (jqXHR, textStatus, errorThrown) { // YOU HAVE TO COMMENT THIS CUS IN CONTROLLER IS PREVENT FOR SESSION
			Swal.fire({
				icon: "error",
				title: "Show detail cart error!",
				showConfirmButton: false,
				timer: 5000,
			});
		}, */
	});
}

function getTotal(row = null) {
	var url = new URL("http://localhost/ecommerce-base/");

	if (row) {
		var price_val = Number($("#price_val_" + row).val());
		var qty_val = Number($("#qty_val_" + row).val());
		var total = price_val * qty_val;
		// total = total.toFixed();

		$("#amount_" + row).text(total);
		$("#amount_val_" + row).val(total);

		subAmount();

		$.ajax({
			url: url.pathname + "update-cart",
			data: {
				product_id: $("#id_product_" + row).val(),
				qty: $("#qty_val_" + row).val(),
				amount: $("#amount_val_" + row).val(),
			},
			type: "POST",
			dataType: "JSON",
			success: function (data) {
				if (data.status == true) {
					showShoppingCart();
				} else {
					Swal.fire({
						icon: "error",
						title: "Quantity is required and, must be more than 0!",
						showConfirmButton: false,
						timer: 2000,
					});

					// total = total.toFixed();
					$("#amount_" + row).text(price_val);
					$("#amount_val_" + row).val(price_val);
					$("#qty_val_" + row).val(1);

					getTotal(row);
					subAmount();
					showShoppingCart();
				}
			},
		});
	} else {
		Swal.fire({
			icon: "error",
			title: "No row, please refresh the page!",
			showConfirmButton: false,
			timer: 5000,
		});
	}
}

// VALIDASI UNTUK MEMBATASI JUMLAH ITEM BELI DENGAN KETERSEDIAN JUMLAH ITEM YANG ADA PER ITEM
function getCartValidateQty(row = null) {
	var url = new URL("http://localhost/ecommerce-base/");

	if (row) {
		$.ajax({
			url: url.pathname + "get-check-qty-product",
			data: {
				product_id: $("#id_product_" + row).val(),
				qty: $("#qty_val_" + row).val(),
			},
			type: "POST",
			dataType: "JSON",
			success: function (data) {
				if (data.status == "true") {
					console.log(true);
				} else {
					Swal.fire({
						icon: "error",
						title: data.message,
						showConfirmButton: false,
						timer: 2000,
					});

					// $("#amount_" + row).text(price_val);
					// $("#amount_val_" + row).val(price_val);
					$("#qty_val_" + row).val(1);

					getTotal(row);
					subAmount();
					showShoppingCart();
				}
			},
		});
	} else {
		Swal.fire({
			icon: "error",
			title: "No row, please refresh the page!",
			showConfirmButton: false,
			timer: 2000,
		});
	}
}

function subAmount() {
	var table_cart_length = $("#cart_table tbody tr").length;
	var total_sub_amount = 0;

	for (var i = 0; i < table_cart_length; i++) {
		var tr = $("#cart_table tbody tr")[i];
		var count = $(tr).attr("id");

		if (count != null) {
			count = count.substring(4);
		}

		total_sub_amount += Number($("#amount_val_" + count).val());
	}

	total_sub_amount = total_sub_amount.toFixed();

	if (total_sub_amount > 0) {
		// sub total
		$("#sub_total").text(total_sub_amount);
		$("#sub_total_val").val(total_sub_amount);

		//total amount JIKA ADA COUPONT TARUH INPUT HIDDEN DIBAWAH FIELD COUPONT BERISIKAN VALUE DISCOUNT
		$("#total").text(total_sub_amount);
		$("#total_val").val(total_sub_amount);
	} else {
		// sub total
		$("#sub_total").text(0);
		$("#sub_total_val").val(0);

		//total amount JIKA ADA COUPONT TARUH INPUT HIDDEN DIBAWAH FIELD COUPONT BERISIKAN VALUE DISCOUNT
		$("#total").text(0);
		$("#total_val").val(0);
	}
}

function removeRow(tr_id) {
	$("#cart_table tbody tr #row_" + tr_id).remove();
	subAmount();
	subAmountCheckOut();
}

// CHECK OUT
/* function getCheckOutBilling() {
	var url = new URL("http://localhost/ecommerce-base/");

	$.ajax({
		url: url.pathname + "get-check-out-billing",
		type: "GET",
		dataType: "JSON",
		success: function (data) {
			$("#name").val(data.customer_name).prop("readonly", true);
			// $("#street").val(data.street_name).prop("readonly", true);
			$("#email").val(data.email).prop("readonly", true);
			$("#phone").val(data.customer_phone).prop("readonly", true);
		},
	});
} */

function getCompanyFullAddress() {
	var url = new URL("http://localhost/ecommerce-base/");

	$.ajax({
		url: url.pathname + "get-company-full-address",
		type: "GET",
		dataType: "JSON",
		success: function (data) {
			$("#company_city_id").val(data.city_id).prop("readonly", true);
		},
	});
}

$("#courier").on("change", function () {
	var url = new URL("http://localhost/ecommerce-base/");

	var courier_id = $("#courier option:selected").val();
	var origin_id = $("#company_city_id").val();
	var destination_id = $("#city_id").val();
	var weight_val = $("#check-out-weight-val").val();
	$(this).valid();

	if (courier_id != null && courier_id != 0) {
		$.ajax({
			url: url.pathname + "get-api-cost-shipment",
			type: "GET",
			data: {
				origin: origin_id,
				destination: destination_id,
				weight: weight_val,
				courier: courier_id,
			},
			dataType: "JSON",
			success: function (data) {
				console.log(data);

				var result = data[0].costs;
				var html = '<option value="">Select Service</option>';
				var i;

				for (i = 0; i < result.length; i++) {
					var text = result[i].description + " (" + result[i].service + ")";
					html +=
						'<option value="' +
						result[i].cost[0].value +
						'" etd="' +
						result[i].cost[0].etd +
						'">' +
						text +
						"</option>";
				}

				$("#service").html(html);
			},
		});
	} else {
		$("#service").html([]);
		$("#service").val([]).trigger("change");
		// $("#service").val([]);
		// $('#estimate').val('');
	}
});

var ongkir = 0;

$("#service").on("change", function () {
	var estimate = $("#service option:selected").attr("etd");
	var service_val = $("#service option:selected").text();
	ongkir = parseInt($(this).val());

	if ($(this).val() != null && $(this).val() != 0) {
		$("#estimate").val(estimate).prop("readonly", true);

		$("#service_val").val(service_val).prop("readonly", true);
		$("#etd_val").val(estimate).prop("readonly", true);
		$("#cost_val").val(ongkir).prop("readonly", true);

		$("#check-out-shippingcost").html("Rp. " + ongkir);
	} else {
		$("#estimate").val("").prop("readonly", true);

		$("#service_val").val("").prop("readonly", true);
		$("#etd_val").val("").prop("readonly", true);
		$("#cost_val").val(0).prop("readonly", true);

		$("#check-out-shippingcost").html("Rp. " + 0);
	}

	subAmountCheckOut();
});

function getCheckOutOrder() {
	var url = new URL("http://localhost/ecommerce-base/");

	$.ajax({
		url: url.pathname + "get-check-out-order",
		type: "GET",
		dataType: "JSON",
		success: function (data) {
			$("#show-check-out-data").html(data.html);
			$("#check-out-subtotal").html(data.cart_total);
			$("#check-out-subtotal-val").val(data.cart_total_val);
			$("#check-out-weight-val").val(data.cart_weight_val);

			subAmountCheckOut();
		},
	});
}

function getCheckCompanyChargeValue() {
	var url = new URL("http://localhost/ecommerce-base/");

	$.ajax({
		url: url.pathname + "get-company-charge-val",
		type: "GET",
		dataType: "JSON",
		success: function (data) {
			$("#check-out-ppn").html(data.vat_charge_value + "%");
			$("#check-out-ppn-charge-rate").val(data.vat_charge_value);

			subAmountCheckOut();
		},
	});
}

// SUB AMOUNT CHECKOUT INCLUDING PPN AND SHIPPING COST
function subAmountCheckOut() {
	var subtotal_val = Number($("#check-out-subtotal-val").val());
	var ppn_charge_rate = Number($("#check-out-ppn-charge-rate").val());
	var shipping_cost = Number($("#cost_val").val());

	var set_ppn = (ppn_charge_rate / 100) * subtotal_val;
	var total_ppn = subtotal_val + set_ppn + shipping_cost;

	Number($("#check-out-ppn-charge-val").val(set_ppn));
	Number($("#check-out-ppn-charge").val(total_ppn));

	var total_val = Number($("#check-out-total-val").val(total_ppn));
	$("#check-out-total").html("Rp. " + total_ppn + "");
}

// INSERT CHECK OUT INTO DATABASE
$("#place-order").on("click", function (e) {
	e.preventDefault();
	$("#place-order").text("Processing..."); //change button text
	$("#place-order").attr("disabled", true); //set button disable

	var $valid = $(".checkout-form").valid();

	if (!$valid) {
		$("#place-order").text("Place Order"); //change button text
		$("#place-order").attr("disabled", false); //set button enable
		return false;
	} else {
		var url = new URL("http://localhost/ecommerce-base/");

		$.ajax({
			url: url.pathname + "insert-check-out",
			type: "POST",
			data: $(".checkout-form").serialize(),
			cache: false,
			dataType: "JSON",
			success: function (data) {
				if (data.status == true) {
					Swal.fire({
						icon: "success",
						title: data.message,
						showConfirmButton: false,
						timer: 5000,
					}).then(function () {
						window.location.href = url + "customer-history-purchase-order";
					});
				} else {
					Swal.fire({
						icon: "error",
						title: data.message,
						showConfirmButton: false,
						timer: 5000,
					});
				}

				showShoppingCart();
				showDetailCart();
				getCheckOutOrder();

				$("#place-order").text("Place Order"); //change button text
				$("#place-order").attr("disabled", false); //set button enable
			},
			error: function (jqXHR, textStatus, errorThrown) {
				Swal.fire({
					icon: "error",
					title: textStatus,
					showConfirmButton: false,
					timer: 5000,
				});

				$("#place-order").text("Place Order"); //change button text
				$("#place-order").attr("disabled", false); //set button enable
			},
		});
	}
});

// FOR DETAIL PRODUCT CART
function setDetailButtonCart() {
	var qty = $("#number_qty").val();
	var qty_val = $("#number_qty_val").val();
	var product_id = $("#product_id").val();
	var product_price = $("#product_price").val();

	var url = new URL("http://localhost/ecommerce-base/");

	if (qty != 0) {
		$.ajax({
			url: url.pathname + "set-detail-shopping-cart",
			data: {
				qty: qty_val,
				product_id: product_id,
				product_price: product_price,
			},
			type: "POST",
			dataType: "JSON",
			success: function (data) {
				if (data.status == "auth") {
					Swal.fire({
						title: "Sorry, you need to sign in!",
						icon: "warning",
						showCancelButton: true,
						confirmButtonColor: "#3085d6",
						cancelButtonColor: "#d33",
						confirmButtonText: "Yes, sign in!",
					}).then((result) => {
						if (result.value) {
							location.href = url.pathname + "sign-in";
						}
					});
				} else {
					if (data.quantity == "true") {
						if (data.status == "insert") {
							Swal.fire({
								icon: "success",
								title: "Successfully added to your shopping cart!",
								showConfirmButton: false,
								timer: 5000,
							});
						} else if (data.status == "update") {
							Swal.fire({
								icon: "success",
								title: "Successfully updated to your shopping cart!",
								showConfirmButton: false,
								timer: 5000,
							});
						}

						showShoppingCart();
					} else {
						Swal.fire({
							icon: "error",
							title: data.message,
							showConfirmButton: false,
							timer: 2000,
						});

						$("#number_qty").val(1);
						$("#number_qty_val").val(1);
					}
				}
			},
		});
	} else {
		Swal.fire({
			icon: "error",
			title: "Quantity is required and, must be more than 0!",
			showConfirmButton: false,
			timer: 2000,
		});
	}
}

// MILIK SEMUA
function deleteShoppingCart(id) {
	var url = new URL("http://localhost/ecommerce-base/");

	$.ajax({
		url: url.pathname + "delete-shopping-cart/" + id,
		type: "POST",
		dataType: "JSON",
		success: function (data) {
			if (data.auth_status == true) {
				Swal.fire({
					title: "Sorry, you need to sign in!",
					icon: "warning",
					showCancelButton: true,
					confirmButtonColor: "#3085d6",
					cancelButtonColor: "#d33",
					confirmButtonText: "Yes, sign in!",
				}).then((result) => {
					if (result.value) {
						location.href = url.pathname + "sign-in";
					}
				});
			} else {
				if (data.status == true) {
					Swal.fire({
						icon: "success",
						title: "Successfully deleted to your shopping cart!",
						showConfirmButton: false,
						timer: 5000,
					});
				} else {
					Swal.fire({
						icon: "error",
						title:
							"Unsuccessfully deleted to your shopping cart, please try again!",
						showConfirmButton: false,
						timer: 5000,
					});
				}

				showShoppingCart();
				showDetailCart();
				getCheckOutOrder();
			}
		},
	});
}
