function validateForm()
{
	// set page form element
	var form = document.detailForm;
	// set flag to TRUE: default all fields correct
	var flag = true;
	// set element flag to -1: default (field not required validation)
	var ef = -1;	
	// check each field in the form
	for(i=0; i<form.elements.length; i++) {
		
		ef=0; // presumed valid
		
		// check any field listed
		switch (form.elements[i].id) {
			case 'firstname':
			case 'surname':
				if(trim(form.elements[i].value)=='') ef=1;
				break;

			case 'email':
				var re = /^[\w-]+(\.[\w-]+)*@([\w-]+\.)+[a-zA-Z]{2,7}$/;
				if(trim(form.elements[i].value)=='' || !form.elements[i].value.match(re)) ef=1;
				break;

			case 'txtCaptcha':
				if(form.elements[i].value.length!=5) ef=1;
				break;

			default:
				// reset element flag (non-required element)
				var ef = -1;
				break;
		}

		if(ef==1) {	// error on field
			form.elements[i].style.backgroundColor = '#DDDDDD';
			flag = false;	// error on form
		} else if(ef==0) {	// reset field if validated
			form.elements[i].style.backgroundColor = '#FFFFFF';
		}
	}
	
	if(!flag) 
	{	alert("Invalid information entered, please complete the highlighted fields (*)."); }
		
	return flag;
}

function validateForm2()
{
	// set page form element
	var form = document.detailForm;
	// set flag to TRUE: default all fields correct
	var flag = true;
	// set element flag to -1: default (field not required validation)
	var ef = -1;	
	// check each field in the form
	for(i=0; i<form.elements.length; i++) {
		
		ef=0; // presumed valid
		
		// check any field listed
		switch (form.elements[i].id) {
			case 'emp_firstname':
			case 'emp_surname':
			case 'emp_suburb':
			case 'emp_phone':
			case 'emp_mobile':
			case 'emp_emp1':
			case 'emp_pos1':
			case 'emp_dur1':
				if(trim(form.elements[i].value)=='') ef=1;
				break;
				
			case 'emp_work':
			case 'emp_permission':
			case 'emp_limit':
			case 'emp_health':
				if(form.elements[i].checked==false && form.elements[(i+1)].checked==false) ef=1;
				i++;
				break			

			case 'emp_time':
				if(form.elements[i].checked==false && form.elements[(i+1)].checked==false && form.elements[(i+2)].checked==false && form.elements[(i+3)].checked==false) ef=1;
				i+=3;
				break			

			default:
				// reset element flag (non-required element)
				var ef = -1;
				break;
		}

		if(ef==1) {	// error on field
			if(form.elements[i].type!='radio' && form.elements[i].type!='checkbox')
				form.elements[i].style.backgroundColor = '#DDDDDD';
			flag = false;	// error on form
		} else if(ef==0) {	// reset field if validated
			form.elements[i].style.backgroundColor = '#FFFFFF';
		}
	}
	
	if(!flag) 
	{	alert("Invalid information entered, please complete the highlighted fields (*)."); }
		
	return flag;
}

