setInterval(function () {
	getPaymentDue();
	getReminderCancelFromPaymentDue();
	getReminderPayment();
}, 30000); //request every x seconds 5 minutes * 60 seconds * 1000 milliseconds = 300000ms

var url = new URL("http://localhost/ecommerce-base/");
var table_purchase_order;

table_purchase_order = $("#table-data-purchase-order").DataTable({
	processing: true,
	serverSide: true,
	ajax: {
		url: url.pathname + "order/show_ajax_order",
		type: "POST",
	},
	dom: "Bfrtip",
	buttons: [
		{
			extend: "pdf",
			oriented: "potrait",
			pageSize: "Legal",
			title: "Data Order",
			download: "open",
			exportOptions: {
				columns: [0, 1, 2, 3, 4, 5, 6, 7],
			},
		},
		{
			extend: "print",
			oriented: "potrait",
			pageSize: "Legal",
			title: "Data Order",
			download: "open",
			exportOptions: {
				columns: [0, 1, 2, 3, 4, 5, 6, 7],
			},
		},
	],
	order: [],
	columnDefs: [
		{
			targets: "no-sort",
			orderable: false,
		},
	],
});

function getPaymentDue() {
	var url = new URL("http://localhost/ecommerce-base/");

	$.ajax({
		url: url.pathname + "get-payment-due",
		type: "GET",
		dataType: "JSON",
		success: function (response) {
			console.log(response.id);
			table_purchase_order.ajax.reload(null, false);
		},
	});
}

function getReminderCancelFromPaymentDue() {
	var url = new URL("http://localhost/ecommerce-base/");

	$.ajax({
		url: url.pathname + "get-reminder-cancel-from-payment-due",
		type: "GET",
		dataType: "JSON",
		success: function () {
			table_purchase_order.ajax.reload(null, false);
		},
	});
}

function getReminderPayment() {
	var url = new URL("http://localhost/ecommerce-base/");

	$.ajax({
		url: url.pathname + "get-reminder-payment",
		type: "GET",
		dataType: "JSON",
		success: function () {
			table_purchase_order.ajax.reload(null, false);
		},
	});
}
