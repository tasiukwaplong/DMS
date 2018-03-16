//js file by tasiu (TK): Feb, 2018 09031514346
function getTr(data){
	var nodeArr = ["names", "item", "phonesNumber", "itemPrice", "dateCollected", "returnDate", "addInfo"];
	for (var i = 1; i <= 7; i++) {

		var childContent = document.getElementById(data).children[i].innerHTML;
		document.getElementsByName(nodeArr[i-1])[0].value = childContent;
	}
}

function delTr(selectr){
	var nodeArr = ["names", "item", "phonesNumber", "itemPrice", "dateCollected", "returnDate", "addInfo"];
	for (var i = 1; i <= 7; i++) {

		var childContent = document.getElementById(selectr).children[i].innerHTML;
		//to change the value of node content
		document.getElementById(nodeArr[i-1]).innerHTML = childContent;
	}
			//to change the value of hidden input
		document.getElementsByName(/*get the id an pass as arg to dleete*/).value = //value of id;

		//i stopped here
}