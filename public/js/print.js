$('#printReceipt').on('click',function () {
	$('#receiptArea').printThis({
		importCSS: true
	});
});