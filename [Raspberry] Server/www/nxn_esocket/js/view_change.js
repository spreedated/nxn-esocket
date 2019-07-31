function view_blocks() {
	var elements = document.getElementsByClassName("socketname_textbutton");
	var names = '';
	for(var i=0; i<elements.length; i++) {
		elements[i].style.width = "118px";
	};

	var elements = document.getElementsByClassName("socketname_textbutton_controlled_device");
	var names = '';
	for(var i=0; i<elements.length; i++) {
		elements[i].style.display = "none";
	};

	var elements = document.getElementsByClassName("socketname_button");
	var names = '';
	for(var i=0; i<elements.length; i++) {
		elements[i].style.display = "inline-block";
		elements[i].style.width = "auto";
		elements[i].style.marginLeft = "30px";
    elements[i].style.marginRight = "30px";
	};
	document.getElementById('socketbutton_wrapper').style.marginTop = '50px';
	document.getElementById('socketbutton_wrapper').style.textAlign = 'center';
	document.getElementById('socketbutton_wrapper').style.width = '480px';
	document.getElementById('socketbutton_wrapper').style.margin = 'auto';
	document.getElementById('socketnumber').style.display = 'none';

	document.getElementById('view_change_icon').className = 'far fa-bars';
}

function view_bars() {
	var elements = document.getElementsByClassName("socketname_textbutton");
	var names = '';
	for(var i=0; i<elements.length; i++) {
		elements[i].style.width = "450px";
	};

	var elements = document.getElementsByClassName("socketname_textbutton_controlled_device");
	var names = '';
	for(var i=0; i<elements.length; i++) {
		elements[i].style.display = "block";
	};

	var elements = document.getElementsByClassName("socketname_button");
	var names = '';
	for(var i=0; i<elements.length; i++) {
		elements[i].style.width = "450px";
		elements[i].style.display = "block";
		elements[i].style.margin = "auto";
		elements[i].style.marginBottom = "16px";
	};
	document.getElementById('socketbutton_wrapper').style.marginTop = '0px';
	document.getElementById('socketnumber').style.display = 'inline-block';

	document.getElementById('view_change_icon').className = 'fas fa-th-large';
}

function view_change() {
	var get_class = document.getElementById('view_change_icon').className;
	if(get_class == 'fas fa-th-large') {
		setCookie('view_of_sockets','blocks',1);
		view_blocks();
	}else {
		setCookie('view_of_sockets','bars',1);
		view_bars();
	}
}

if (getCookie('view_of_sockets') !== 'false') {
	switch (getCookie('view_of_sockets')) {
		case 'blocks':
			view_blocks();
		break;
	}
}
