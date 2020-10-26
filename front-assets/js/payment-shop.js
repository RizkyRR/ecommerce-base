setInterval(function () {
	getPaymentDue();
	getReminderCancelFromPaymentDue();
	getReminderPayment();
}, 30000); //request every x seconds 5 minutes * 60 seconds * 1000 milliseconds = 300000ms

var url = new URL("http://localhost/ecommerce-base/");

table_history_payment = $("#table-data-purchase-order").DataTable({
	processing: true,
	serverSide: true,
	ajax: {
		url: url.pathname + "get-data-customer-purchase",
		type: "POST",
	},
	dom: "Bfrtip",
	columnDefs: [
		{
			targets: [0, 3, 4, 6],
			orderable: false,
			searchable: false,
		},
	],
	order: [],
});

function getPaymentDue() {
	var url = new URL("http://localhost/ecommerce-base/");

	$.ajax({
		url: url.pathname + "get-payment-due",
		type: "GET",
		dataType: "JSON",
		success: function () {
			table_history_payment.ajax.reload(null, false);
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
			table_history_payment.ajax.reload(null, false);
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
			table_history_payment.ajax.reload(null, false);
		},
	});
}
