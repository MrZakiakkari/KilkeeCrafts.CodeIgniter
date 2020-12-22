function goBack() {
	window.history.back();
}

function checkDelete(){
	if (confirm("Are you sure you want to delete this record?"))
		return true;
	else
		return false;
}