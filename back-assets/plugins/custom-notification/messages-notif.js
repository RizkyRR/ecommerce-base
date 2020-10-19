$(document).ready(function () {
	setInterval(function () {
		incomingChatUnread();
		showCountIncomingLabel();
		showCountIncomingHeader();
	}, 2000); //request every x seconds
});

// to show all chat coming
function incomingChatUnread() {
	var html = "";
	var url = new URL("http://localhost/ecommerce-base/");

	// to get count chat coming or not yet ready
	$.ajax({
		url: url.pathname + "chat/chat_count_unread",
		type: "ajax",
		dataType: "JSON",
		success: function (data) {
			if (data > 0) {
				html =
					'<a href="#">' +
					'<i class="fa fa-comments text-yellow"></i><span id="count-chat"></span> Chat</a>';
			}

			$("#show-count-chat").html(html);
			$("#count-chat").html(data);
		},
	});
}

// to show all comment coming

// to count all messages
function showCountIncomingLabel() {
	var jumlah;

	var getCountChat = Number($("#count-chat").val());
	var getCountComment = Number($("#count-comment").val());

	jumlah = getCountChat + getCountComment;

	if (jumlah > 0) {
		$(".show-count-incoming-label").val(jumlah);
	} else {
		$(".show-count-incoming-label").val(0);
	}
}

function showCountIncomingHeader() {
	var jumlah;
	var header = "";

	var getCountChat = Number($("#count-chat").val());
	var getCountComment = Number($("#count-comment").val());

	jumlah = getCountChat + getCountComment;

	if (jumlah > 0) {
		header = "You have " + jumlah + " messages";
		$("#show-count-incoming-header").val(header);
	} else {
		header = "You have 0 message";
		$("#show-count-incoming-header").val(header);
	}
}
