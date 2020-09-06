// function callThisFunction() {
//     alert("Hi!");
// }

// function processJsonData() {
//     let jsondata = document.getElementById('jsondiv');

//     let jsonobject = JSON.parse(jsondata.innerHTML);

//     console.log(jsonobject[0].l_item);

//     let ul = document.createElement("ul");

//     for (let i = 0; i < jsonobject.length; i++) {
//         let li = document.createElement("li");
//         li.innerHTML = jsonobject[i].l_item;
//         ul.appendChild(li);
//     }

//     console.log(ul);
//     document.body.appendChild(ul);

// }

function AddMoreItem(){
	var new_list = "<li><input type='text' placeholder='New List Item' class='list_item_part' value='' name='listItem[]'></li>"
	$('.list_item :last').after(new_list); // add it to interface

}

function AddToDoList(){
	var list_name = $('input[name=listName]').val(); // list name
	var list_items = $('input[name ^=listItem]').serializeArray(); // this will get  the list item where the input name starts with listItem (^=)
	$.ajax({
	  method: "POST",
	  url: "includes/processform.php",
	  data: {'submitListItem': 'submitListItem','list_name':list_name , 'list_items': list_items}
	})
	  .done(function( msg ) {
	  	console.log(msg);
	  	if(msg == 'Success!'){
	  		window.location.href="index.php";
	  	}
	    // alert( "Data Saved: " + msg );
	  });
}

function UpdateItemList(list_id){
	var list_name = $('input[name=listName]').val(); // list name
	var list_items = $('input[name ^="listItem["]').serializeArray(); // this will get  the new list item where the input name starts with listItem (^=)
	var list_item_existed = $('input[name ^="listItem_"]').serializeArray(); // this will get  the existing  list item where the input name starts with listItem (^=)

	console.log(list_item_existed);
	var existing_items = 
	$.ajax({
	  method: "POST",
	  url: "includes/processform.php",
	  data: {'updateListItem': 'updateListItem','list_name':list_name , 'list_items': list_items,'list_item_existed':list_item_existed,'list_id':list_id}
	})
	  .done(function( msg ) {
	  	console.log(msg);
	  	if(msg == 'Success!'){
	  		window.location.href="index.php";
	  	}
	    // alert( "Data Saved: " + msg );
	  });
}


function tryQuickEdit(list_id){
	$('#quick'+list_id).show() ; // show the hidden div using the list id
}



/**Save the input of the text box **/
function QuickEditSave(list_id){
	var list_name = $('input[name=quick_edit_'+list_id+']').val(); // list name
	
	$.ajax({
	  method: "POST",
	  url: "includes/processform.php",
	  data: {'updateListItem': 'updateListItem','list_name':list_name ,'list_id':list_id}
	})
	  .done(function( msg ) {
	  	console.log(msg);
	  	if(msg == 'Success!'){
	  		list_name = list_name.replace(/[^a-zA-Z0-9 \s]/gi, '');//sanitize remove special characters
	  		$('p#list_name_'+list_id).text(list_name);// replace the text on the list
	  		$('div#quick'+list_id).hide();//hide the input row

	  	}
	  });
}

/**Save the input of the text box **/

function QuickEditCancel(list_id){
		$('div#quick'+list_id).hide();//hide the input row
}

/**enable profile edit**/
function enableProfileEdit(){
	$('input').removeAttr('disabled'); //remove the disable of the inputs
}

/**Cancel Changes in user profle**/
function CancelUserProfile(){
	window.location.reload();
}