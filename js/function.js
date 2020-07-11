function addProduct(code){
	var amount = document.getElementById(code).value;
	window.location.href = 'home.php?action=add&code='+code+'&amount='+amount;
}

function deleteProduct(code){
	window.location.href = 'home.php?action=remove&code='+code;
}

function payProduct() {
	var form = document.carry;
	if(form.carry.value == ""){
	    alert("You must select transport type");
	    return false;
	}
}

function validateSelectRate() {
	var form = document.rating;
	if(form.rate_product.value == ""){
	    alert("You must select a range");
	    return false;
}