$(document).ready(function () {
	setInterval(function () {
		incomingReviewUnreadInfo();
		incomingMessageUnreadInfo();
		showCountIncomingLabel();
		showCountIncomingHeader();
	}, 2000); //request every x seconds
});

// to show all chat coming
function incomingReviewUnreadInfo() {
	var html = "";
	var url = new URL("http://localhost/ecommerce-base/");

	// to get count chat coming or not yet ready
	$.ajax({
		url: url.pathname + "message/getCountIncomingUnreadReview",
		type: "GET",
		dataType: "JSON",
		success: function (data) {
			if (data > 0) {
				html =
					'<a href="' +
					url.pathname +
					'review"><i class="fa fa-comments text-teal" aria-hidden="true"></i><span id="count-incoming-review"></span> Review/s</a>';
			}

			$("#show-review-notif").html(html);
			$("#count-incoming-review").html(data);
		},
	});
}

function incomingMessageUnreadInfo() {
	var html = "";
	var url = new URL("http://localhost/ecommerce-base/");

	// to get count chat coming or not yet ready
	$.ajax({
		url: url.pathname + "message/getCountIncomingUnreadMessage",
		type: "GET",
		dataType: "JSON",
		success: function (data) {
			if (data > 0) {
				html =
					'<a href="' +
					url.pathname +
					'message"><i class="fa fa-envelope text-aqua" aria-hidden="true"></i><span id="count-incoming-message"></span> Message/s</a>';
			}

			$("#show-message-notif").html(html);
			$("#count-incoming-message").html(data);
		},
	});
}

// to show all comment coming

// to count all messages
function showCountIncomingHeader() {
	var jumlah;
	var header = "";

	var getCountReview = Number($("#count-incoming-review").text());
	var getCountMessage = Number($("#count-incoming-message").text());

	jumlah = getCountReview + getCountMessage;

	if (jumlah > 0) {
		header = "You have " + jumlah + " notification!";
		$("#show-count-incoming-header").text(header);
	} else {
		header = "You have 0 notification!";
		$("#show-count-incoming-header").text(header);
	}
}

function showCountIncomingLabel() {
	var jumlah;

	var getCountReview = Number($("#count-incoming-review").text());
	var getCountMessage = Number($("#count-incoming-message").text());

	jumlah = getCountReview + getCountMessage;

	if (jumlah > 0) {
		$(".show-count-incoming-label").text(jumlah);
	} else {
		$(".show-count-incoming-label").text(0);
	}
}
