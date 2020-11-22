$(document).ready(function (e) {
	// for profile company
	show_base_profile();
	showDataProvince();
	show_full_address();
	show_social_media();
	show_charge_value();
	show_bank_account();
	show_email();
	show_set_alert();

	$("#company-full-address").hide();
	// $(".select_group").select2();

	// number qty
	$("#service_charge_value").attr({
		min: 0, // values (or variables) here
	});

	$("#vat_charge_value").attr({
		min: 0, // values (or variables) here
	});

	$.validator.setDefaults({
		highlight: function (element) {
			$(element).closest(".form-group").addClass("has-error");
		},
		unhighlight: function (element) {
			$(element).closest(".form-group").removeClass("has-error");
		},
		errorElement: "span",
		errorClass: "error-message",
		errorPlacement: function (error, element) {
			if (element.parent(".input-group").length) {
				error.insertAfter(element.parent()); // radio/checkbox?
			} else if (element.hasClass("select2-hidden-accessible")) {
				/* else if (element.hasClass('select2')) {
             error.insertAfter(element.next('span')); // select2
           } */
				error.insertAfter(element.next("span.select2")); // select2 new ver
			} else {
				error.insertAfter(element); // default
			}
		},
	});

	// https://stackoverflow.com/questions/37606285/how-to-validate-email-using-jquery-validate/37606312
	$.validator.addMethod(
		/* The value you can use inside the email object in the validator. */
		"regex",

		/* The function that tests a given string against a given regEx. */
		function (value, element, regexp) {
			/* Check if the value is truthy (avoid null.constructor) & if it's not a RegEx. (Edited: regex --> regexp)*/

			if (regexp && regexp.constructor != RegExp) {
				/* Create a new regular expression using the regex argument. */
				regexp = new RegExp(regexp);
			} else if (regexp.global) regexp.lastIndex = 0;

			/* Check whether the argument is global and, if so set its last index to 0. */

			/* Return whether the element is optional or the result of the validation. */
			return this.optional(element) || regexp.test(value);
		}
	);

	var $validatorBaseProfile = $("#base-profile").validate({
		focusInvalid: false,
		rules: {
			name: {
				required: true,
			},
			email: {
				required: true,
				email: true,
				regex: /^\b[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i,
			},
			phone: {
				required: true,
				number: true,
			},
			about: {
				required: true,
				minlength: 50,
			},
		},
	});

	var $validatorAddress = $("#company-address").validate({
		focusInvalid: false,
		rules: {
			province: {
				required: true,
			},
			regency: {
				required: true,
			},
			street_name: {
				required: true,
				minlength: 30,
			},
		},
		messages: {
			province: {
				required: "Province is required!",
			},
			regency: {
				required: "Regency is required!",
			},
			street_name: {
				required: "Street name is required!",
				minlength: "Your street name too short, at least 30 char!",
			},
		},
	});

	var $validatorChargeValue = $("#set-charge-value").validate({
		focusInvalid: false,
		rules: {
			service_charge_value: {
				number: true,
			},
			vat_charge_value: {
				number: true,
			},
		},
	});

	var $validatorBankAccount = $("#bank-account").validate({
		focusInvalid: false,
		rules: {
			bank_name: {
				required: true,
			},
			account: {
				required: true,
			},
			bank_account_holder: {
				required: true,
			},
		},
		messages: {
			bank_name: {
				required: "Bank's name is required!",
			},
			account: {
				required: "Account's number is required!",
			},
			bank_account_holder: {
				required: "Bank account holder's name is required!",
			},
		},
	});

	var $validatorSetEmail = $("#set-email").validate({
		focusInvalid: false,
		rules: {
			email_registry: {
				required: true,
				email: true,
				regex: /^\b[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i,
			},
			password_registry: {
				required: true,
			},
		},
	});

	var $validatorDashboard = $("#form-dash").validate({
		focusInvalid: false,
		rules: {
			icon: {
				required: true,
			},
			color: {
				required: true,
			},
			title: {
				required: true,
			},
		},
		messages: {
			title: {
				required: "Dashboard's title is required!",
			},
		},
	});

	var $validatorSetAlert = $("#form-set-alert").validate({
		focusInvalid: false,
		rules: {
			min_stock_product_val: {
				required: true,
				number: true,
			},
		},
	});

	// ADDRESS PURPOSES
	$("#province").select2({
		placeholder: "Select for a province",
		allowClear: true,
	});

	$("#regency").select2({
		placeholder: "Select for a regency",
		allowClear: true,
	});

	function showDataProvince() {
		var url = new URL("http://localhost/ecommerce-base/");

		$.ajax({
			url: url.pathname + "get-api-province",
			type: "GET",
			dataType: "JSON",
			success: function (data) {
				var html = '<option value=""></option>';
				var i;

				for (i = 0; i < data.length; i++) {
					html +=
						'<option value="' + data[i].id + '">' + data[i].text + "</option>";
				}
				$("#province").html(html);
			},
		});
	}

	$("#province").on("change", function () {
		var url = new URL("http://localhost/ecommerce-base/");

		var province_id = $("#province option:selected").val();
		var province_name = $("#province option:selected").text();

		$("#regency").empty();
		$(this).valid();
		$("#province_name").val(province_name);

		if (province_id != null && province_id != 0) {
			$.ajax({
				url: url.pathname + "get-api-city",
				type: "GET",
				data: {
					province_id: province_id,
				},
				dataType: "JSON",
				success: function (data) {
					var html = '<option value=""></option>';
					var i;

					for (i = 0; i < data.length; i++) {
						html +=
							'<option value="' +
							data[i].city_id +
							'">' +
							data[i].city_name +
							" (" +
							data[i].type +
							")</option>";
					}

					$("#regency").html(html);
				},
			});
		}
	});

	// Untuk menghilangkan pesan validasi jika sudah terisi
	$("#regency").on("change", function () {
		$(this).valid();

		var regency_name = $("#regency option:selected").text();
		$("#regency_name").val(regency_name);
	});

	function show_full_address() {
		var url = new URL("http://localhost/ecommerce-base/");

		$.ajax({
			url: url.pathname + "company/getAddressDetailProvinceCity",
			type: "GET",
			dataType: "JSON",
			success: function (data) {
				var fullAddress =
					data.street_name + ", " + data.city_name + ", " + data.province;

				if (data != null) {
					$("#company-full-address").show();
					$("#show-full-address").html(data.html);
				} else {
					$("#company-full-address").hide();
				}
			},
		});
	}

	$(".btn-submit-companyaddress").click(function (e) {
		$(".btn-submit-companyaddress").text("Submitting..."); //change button text
		$(".btn-submit-companyaddress").attr("disabled", true); //set button disable

		var $valid = $("#company-address").valid();
		if (!$valid) {
			$(".btn-submit-companyaddress").text("Submit"); //change button text
			$(".btn-submit-companyaddress").attr("disabled", false); //set button enable
			return false;
		} else {
			var url = new URL("http://localhost/ecommerce-base/");

			$.ajax({
				url: url.pathname + "company/updateDataCompanyAddress",
				type: "POST",
				data: $("#company-address").serialize(),
				dataType: "JSON",
				success: function (data) {
					if (data.status == "true") {
						//if success close modal and reload ajax table
						Swal.fire({
							icon: "success",
							title: data.notif,
							showConfirmButton: false,
							timer: 3000,
						});
					} else {
						Swal.fire({
							icon: "error",
							title: data.notif,
							showConfirmButton: false,
							timer: 3000,
						});
					}

					$("#company-address").validate().resetForm();
					$("#company-address").valid();

					$("#company-address")[0].reset(); // reset form on modals
					$("#province").select2({
						data: [
							{
								id: "",
								text: "",
							},
						],
						placeholder: "Select for a province",
					});
					// $('#province').val(null).trigger("change");
					// $('#province').empty().select2();
					$("#regency").select2({
						data: [
							{
								id: "",
								text: "",
							},
						],
						placeholder: "Select for a regency",
					});
					// $('#regency').val(null).trigger("change");
					// $('#regency').empty().select2();

					show_full_address();

					$(".btn-submit-companyaddress").text("Submit"); //change button text
					$(".btn-submit-companyaddress").attr("disabled", false); //set button enable
				},
				error: function (jqXHR, textStatus, errorThrown) {
					Swal.fire({
						icon: "error",
						title: errorThrown,
						showConfirmButton: false,
						timer: 3000,
					});

					$(".btn-submit-companyaddress").text("Submit"); //change button text
					$(".btn-submit-companyaddress").attr("disabled", false); //set button enable
				},
			});
		}
	});

	// SHOW DATA BASE PROFILE
	function show_base_profile() {
		var url = new URL("http://localhost/ecommerce-base/");

		$.ajax({
			url: url.pathname + "company/getDataBaseProfile",
			type: "GET",
			dataType: "JSON",
			success: function (data) {
				$('[name="name"]').val(data.company_name);
				$('[name="email"]').val(data.business_email);
				$('[name="phone"]').val(data.phone);
				$('[name="old_logo"]').val(data.image).prop("readonly", true);
				$("#image-container").html(
					'<img class="img-responsive" style="width: 128px; height: 64px;" src="' +
						url.pathname +
						"image/logo/" +
						"" +
						data.image +
						'" />'
				);
				$('[name="about"]').val(data.about);
			},
		});
	}

	$(".btn-submit-baseprofile").click(function (e) {
		$(".btn-submit-baseprofile").text("Submitting..."); //change button text
		$(".btn-submit-baseprofile").attr("disabled", true); //set button disable

		var formData = new FormData($("#base-profile")[0]);

		var $valid = $("#base-profile").valid();
		if (!$valid) {
			$(".btn-submit-baseprofile").text("Submit"); //change button text
			$(".btn-submit-baseprofile").attr("disabled", false); //set button enable
			return false;
		} else {
			var url = new URL("http://localhost/ecommerce-base/");

			$.ajax({
				url: url.pathname + "company/updateDataBaseProfile",
				type: "POST",
				processData: false,
				contentType: false,
				cache: false,
				data: formData,
				enctype: "multipart/form-data",
				dataType: "JSON",
				success: function (data) {
					if (data.status == true) {
						//if success close modal and reload ajax table
						Swal.fire({
							icon: "success",
							title: data.notif,
							showConfirmButton: false,
							timer: 3000,
						});
					} else {
						Swal.fire({
							icon: "error",
							title: data.notif,
							showConfirmButton: false,
							timer: 3000,
						});
					}

					$('[name="logo"]').val("");

					show_base_profile();

					$(".btn-submit-baseprofile").text("Submit"); //change button text
					$(".btn-submit-baseprofile").attr("disabled", false); //set button enable
				},
				error: function (jqXHR, textStatus, errorThrown) {
					Swal.fire({
						icon: "error",
						title: textStatus,
						showConfirmButton: false,
						timer: 3000,
					});

					$(".btn-submit-baseprofile").text("Submit"); //change button text
					$(".btn-submit-baseprofile").attr("disabled", false); //set button enable
				},
			});
		}
	});

	// SOCIAL MEDIA
	function show_social_media() {
		var url = new URL("http://localhost/ecommerce-base/");

		$.ajax({
			url: url.pathname + "company/getCompanySocialMedia",
			type: "GET",
			dataType: "JSON",
			success: function (data) {
				$("#show-data-social").html(data.html);
			},
			error: function (jqXHR, textStatus, errorThrown) {
				Swal.fire({
					icon: "error",
					title: errorThrown,
					showConfirmButton: false,
					timer: 3000,
				});
			},
		});
	}

	$("#add_row_sosmed").click(function (e) {
		var table = $("#link_info_table");
		var count_table_tbody_tr = $("#link_info_table tbody tr").length;
		// console.log(count_table_tbody_tr);
		var row_id = count_table_tbody_tr + 1;
		var html = "";

		var url = new URL("http://localhost/ecommerce-base/");

		$.ajax({
			url: url.pathname + "company/getTableLinkRow",
			type: "POST",
			dataType: "JSON",
			success: function (response) {
				html =
					'<tr id="row_' +
					row_id +
					'">' +
					"<td>" +
					'<select class="form-control select_group link" data-row-id="' +
					row_id +
					'" id="link_' +
					row_id +
					'" name="link[]" style="width:100%;">';
				$.each(response, function (index, value) {
					html +=
						'<option value="' + value.id + '">' + value.link_name + "</option>";
				});

				html += "</select></td>";

				html +=
					'<td><input type="text" name="url[]" id="url_' +
					row_id +
					'" class="form-control url" required></td>';

				html +=
					'<td><button type="button" name="remove" id="remove" class="btn btn-danger btn-sm"  onclick="removeRow(\'' +
					row_id +
					'\')"><i class="fa fa-close"></i></button></td>';

				html += "</tr>";

				if (count_table_tbody_tr >= 1) {
					$("#link_info_table tbody tr:last").after(html);
				} else {
					$("#link_info_table tbody").html(html);
				}

				// $(".select_group").select2();
			},
		});
		return false;
	});

	$(".btn-submit-socialmedia").click(function (e) {
		$(".btn-submit-socialmedia").text("Submitting..."); //change button text
		$(".btn-submit-socialmedia").attr("disabled", true); //set button disable

		var url = new URL("http://localhost/ecommerce-base/");

		$.ajax({
			url: url.pathname + "company/actionCompanySocialMedia",
			type: "POST",
			data: $("#social-media").serialize(),
			dataType: "JSON",
			success: function (data) {
				if (data.status == true) {
					Swal.fire({
						icon: "success",
						title: data.notif,
						showConfirmButton: false,
						timer: 3000,
					});
				} else {
					Swal.fire({
						icon: "error",
						title: data.notif,
						showConfirmButton: false,
						timer: 3000,
					});
				}

				show_social_media();

				$(".btn-submit-socialmedia").text("Submit"); //change button text
				$(".btn-submit-socialmedia").attr("disabled", false); //set button enable

				/* Swal.fire({
          icon: "success",
          title: 'Social media link has been set!',
          showConfirmButton: false,
          timer: 3000,
        });

        show_social_media();

        $('.btn-submit-socialmedia').text('Submit'); //change button text
        $('.btn-submit-socialmedia').attr('disabled', false); //set button enable  */
			},
		});
	});

	// SET CHARGE VALUE
	function show_charge_value() {
		var url = new URL("http://localhost/ecommerce-base/");

		$.ajax({
			url: url.pathname + "company/getChargeValue",
			type: "GET",
			dataType: "JSON",
			success: function (data) {
				$("#service_charge_value").val(data.service_charge_value);
				$("#vat_charge_value").val(data.vat_charge_value);
			},
			error: function (jqXHR, textStatus, errorThrown) {
				Swal.fire({
					icon: "error",
					title: textStatus,
					showConfirmButton: false,
					timer: 3000,
				});
			},
		});
	}

	$(".btn-submit-chargevalue").click(function (e) {
		$(".btn-submit-chargevalue").text("Submitting..."); //change button text
		$(".btn-submit-chargevalue").attr("disabled", true); //set button disable

		var $valid = $("#set-charge-value").valid();
		if (!$valid) {
			$(".btn-submit-chargevalue").text("Submit"); //change button text
			$(".btn-submit-chargevalue").attr("disabled", false); //set button enable
			return false;
		} else {
			var url = new URL("http://localhost/ecommerce-base/");

			$.ajax({
				url: url.pathname + "company/actionChargeValue",
				type: "POST",
				data: $("#set-charge-value").serialize(),
				dataType: "JSON",
				success: function (data) {
					if (data.status == "update") {
						//if success close modal and reload ajax table
						Swal.fire({
							icon: "success",
							title: "Charge value has been updated!",
							showConfirmButton: false,
							timer: 3000,
						});
					} else {
						Swal.fire({
							icon: "success",
							title: "Charge value has been set!",
							showConfirmButton: false,
							timer: 3000,
						});
					}

					show_charge_value();

					$(".btn-submit-chargevalue").text("Submit"); //change button text
					$(".btn-submit-chargevalue").attr("disabled", false); //set button enable
				},
				error: function (jqXHR, textStatus, errorThrown) {
					Swal.fire({
						icon: "error",
						title: textStatus,
						showConfirmButton: false,
						timer: 3000,
					});

					$(".btn-submit-chargevalue").text("Submit"); //change button text
					$(".btn-submit-chargevalue").attr("disabled", false); //set button enable
				},
			});
		}
	});

	// BANK ACCOUNT
	function show_bank_account() {
		var url = new URL("http://localhost/ecommerce-base/");

		$.ajax({
			url: url.pathname + "company/getCompanyBankAccount",
			type: "GET",
			dataType: "JSON",
			success: function (data) {
				$("#show-data-bankaccount").html(data.html);
			},
			error: function (jqXHR, textStatus, errorThrown) {
				Swal.fire({
					icon: "error",
					title: errorThrown,
					showConfirmButton: false,
					timer: 3000,
				});
			},
		});
	}

	$("#add_row_bankaccount").click(function (e) {
		var table = $("#bankaccount_info_table");
		var count_table_tbody_tr = $("#bankaccount_info_table tbody tr").length;
		// console.log(count_table_tbody_tr);
		var row_id = count_table_tbody_tr + 1;
		var html = '<tr id="row_' + row_id + '">';

		html +=
			'<td><input type="text" name="bank_name[]" id="bank_name_' +
			row_id +
			'" class="form-control bank_name" required></td>';

		html +=
			'<td><input type="text" name="account[]" id="account_' +
			row_id +
			'" class="form-control account" required></td>';

		html +=
			'<td><input type="text" name="bank_account_holder[]" id="bank_account_holder_' +
			row_id +
			'" class="form-control bank_account_holder" required></td>';

		html +=
			'<td><button type="button" name="remove_bank_account_row" id="remove_bank_account_row' +
			row_id +
			'" class="btn btn-danger btn-sm"  onclick="removeBankAccountRow(\'' +
			row_id +
			'\')"><i class="fa fa-close"></i></button></td>';

		html += "</tr>";

		if (count_table_tbody_tr >= 1) {
			$("#bankaccount_info_table tbody tr:last").after(html);
		} else {
			$("#bankaccount_info_table tbody").html(html);
		}
	});

	$(".btn-submit-bankaccount").click(function (e) {
		$(".btn-submit-bankaccount").text("Submitting..."); //change button text
		$(".btn-submit-bankaccount").attr("disabled", true); //set button disable

		e.preventDefault();
		var $valid = $("#bank-account").valid();

		if (!$valid) {
			$(".btn-submit-bankaccount").text("Submit"); //change button text
			$(".btn-submit-bankaccount").attr("disabled", false); //set button enable
			return false;
		} else {
			var url = new URL("http://localhost/ecommerce-base/");

			$.ajax({
				url: url.pathname + "company/actionCompanyBankAccount",
				type: "POST",
				data: $("#bank-account").serialize(),
				dataType: "JSON",
				success: function (data) {
					if (data.status == true) {
						Swal.fire({
							icon: "success",
							title: data.notif,
							showConfirmButton: false,
							timer: 3000,
						});
					} else {
						Swal.fire({
							icon: "error",
							title: data.notif,
							showConfirmButton: false,
							timer: 3000,
						});
					}

					show_bank_account();

					$(".btn-submit-bankaccount").text("Submit"); //change button text
					$(".btn-submit-bankaccount").attr("disabled", false); //set button enable
				},
			});
		}
	});

	// SET EMAIL
	function show_email() {
		var url = new URL("http://localhost/ecommerce-base/");

		$.ajax({
			url: url.pathname + "company/getEmail",
			type: "GET",
			dataType: "JSON",
			success: function (data) {
				$("#email_registry").val(data.email);
				$("#password_registry").val(data.password);
			},
			error: function (jqXHR, textStatus, errorThrown) {
				Swal.fire({
					icon: "error",
					title: textStatus,
					showConfirmButton: false,
					timer: 3000,
				});
			},
		});
	}

	$(".btn-submit-email").click(function (e) {
		$(".btn-submit-email").text("Submitting..."); //change button text
		$(".btn-submit-email").attr("disabled", true); //set button disable

		var $valid = $("#set-email").valid();
		if (!$valid) {
			$(".btn-submit-email").text("Submit"); //change button text
			$(".btn-submit-email").attr("disabled", false); //set button enable
			return false;
		} else {
			var url = new URL("http://localhost/ecommerce-base/");

			$.ajax({
				url: url.pathname + "company/actionSetEmail",
				type: "POST",
				data: $("#set-email").serialize(),
				dataType: "JSON",
				success: function (data) {
					if (data.status == "update") {
						//if success close modal and reload ajax table
						Swal.fire({
							icon: "success",
							title: "Charge value has been updated!",
							showConfirmButton: false,
							timer: 3000,
						});
					} else {
						Swal.fire({
							icon: "success",
							title: "Charge value has been set!",
							showConfirmButton: false,
							timer: 3000,
						});
					}

					show_email();

					$(".btn-submit-email").text("Submit"); //change button text
					$(".btn-submit-email").attr("disabled", false); //set button enable
				},
				error: function (jqXHR, textStatus, errorThrown) {
					Swal.fire({
						icon: "error",
						title: textStatus,
						showConfirmButton: false,
						timer: 3000,
					});

					$(".btn-submit-email").text("Submit"); //change button text
					$(".btn-submit-email").attr("disabled", false); //set button enable
				},
			});
		}
	});

	// SET ALERT VALUE
	function show_set_alert() {
		var url = new URL("http://localhost/ecommerce-base/");

		$.ajax({
			url: url.pathname + "company/getAlertValue",
			type: "GET",
			dataType: "JSON",
			success: function (data) {
				$("#min_stock_product_val").val(data.minimum_stock_value);
			},
			error: function (jqXHR, textStatus, errorThrown) {
				Swal.fire({
					icon: "error",
					title: textStatus,
					showConfirmButton: false,
					timer: 3000,
				});
			},
		});
	}

	$(".btn-submit-setalert").click(function (e) {
		$(".btn-submit-setalert").text("Submitting..."); //change button text
		$(".btn-submit-setalert").attr("disabled", true); //set button disable

		var $valid = $("#form-set-alert").valid();
		if (!$valid) {
			$(".btn-submit-setalert").text("Submit"); //change button text
			$(".btn-submit-setalert").attr("disabled", false); //set button enable
			return false;
		} else {
			var url = new URL("http://localhost/ecommerce-base/");

			$.ajax({
				url: url.pathname + "company/actionAlertValue",
				type: "POST",
				data: $("#form-set-alert").serialize(),
				dataType: "JSON",
				success: function (data) {
					if (data.status == "update") {
						//if success close modal and reload ajax table
						Swal.fire({
							icon: "success",
							title: "Charge value has been updated!",
							showConfirmButton: false,
							timer: 3000,
						});
					} else {
						Swal.fire({
							icon: "success",
							title: "Charge value has been set!",
							showConfirmButton: false,
							timer: 3000,
						});
					}

					show_set_alert();

					$(".btn-submit-setalert").text("Submit"); //change button text
					$(".btn-submit-setalert").attr("disabled", false); //set button enable
				},
				error: function (jqXHR, textStatus, errorThrown) {
					Swal.fire({
						icon: "error",
						title: textStatus,
						showConfirmButton: false,
						timer: 3000,
					});

					$(".btn-submit-setalert").text("Submit"); //change button text
					$(".btn-submit-setalert").attr("disabled", false); //set button enable
				},
			});
		}
	});
}); // /document

function numberFormat(element) {
	element.value = element.value.replace(/[^0-9]+/g, "");
}

// DELETE ROW TABLE SOCIAL MEDIA
function removeRow(tr_id) {
	$("#link_info_table tbody tr#row_" + tr_id).remove();
}

function removeBankAccountRow(tr_id) {
	$("#bankaccount_info_table tbody tr#row_" + tr_id).remove();
}

$(function () {
	// Replace the <textarea id="editor1"> with a CKEditor
	// instance, using default configuration.
	CKEDITOR.replace("editor1");
	//bootstrap WYSIHTML5 - text editor
	$(".textarea").wysihtml5();
});
