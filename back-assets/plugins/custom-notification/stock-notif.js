$(document).ready(function () {
	setInterval(function () {
		incomingStockLimitInfo();
		incomingStockLimitCount();
	}, 2000); //request every x seconds
});

// to show all stock coming
function incomingStockLimitInfo() {
	var url = new URL("http://localhost/ecommerce-base/");
	var html = "";
	var i;
	// to get count stock coming or not yet ready
	$.ajax({
		url: url.pathname + "product/getProductLessStockInfo",
		type: "ajax",
		dataType: "JSON",
		success: function (data) {
			for (i = 0; i < data.length; i++) {
				// TOLONG DICEK LAGI KARENA ADA MASALAH KETIKA DITAMBAHKAN DENGAN MODAL
				html +=
					'<a href="#" title="' +
					data[i].id +
					'">' +
					'<i class="fa fa-exclamation-circle text-red"></i>' +
					data[i].product_name +
					"'s" +
					" Stock in Limit!</a>";
			}

			$("#show-count-stock-limit").html(html);
		},
	});
}

function incomingStockLimitCount() {
	var url = new URL("http://localhost/ecommerce-base/");
	var html = "";
	// to get count stock coming or not yet ready
	$.ajax({
		url: url.pathname + "product/getProductLessStockCount",
		type: "ajax",
		dataType: "JSON",
		success: function (data) {
			if (data > 0) {
				$("#show-count-stock-limit-label").html(data);
				$("#show-count-stock-limit-header").html(
					"Anda memiliki " + data + " pemberitahuan"
				);
			} else {
				$("#show-count-stock-limit-label").html(0);
				$("#show-count-stock-limit-header").html(
					"Anda tidak memiliki pemberitahuan apapun"
				);
			}

			if (data > 5) {
				html = '<a href="product">View all</a>';
			}

			$(".show-view-all-stock").html(html);
		},
	});
}

/* function showCountStockLimitHeader() {
	var jumlah;
	var header = "";

	var getCountChat = Number($("#count-chat").val());
	var getCountComment = Number($("#count-comment").val());

	jumlah = getCountChat + getCountComment;

	if (jumlah > 0) {
		header = "You have " + jumlah + " messages";
		$("#show-count-stock-limit-header").val(header);
	} else {
		header = "You have 0 message";
		$("#show-count-stock-limit-header").val(header);
	}
} */
