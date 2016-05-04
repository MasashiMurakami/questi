function changeFontSize(slider_id, image_id1, image_id2, span_id) {
	var point = document.getElementById(slider_id).value;
	if(point<-100) {
		var size = Math.abs(point)*16/100;
		document.getElementById(image_id1).style.fontSize = size + 'px';
		document.getElementById(span_id+"-1").innerHTML = Math.abs(Math.round(point/100));
		document.getElementById(span_id+"-1").style.display = "block";
		document.getElementById(span_id+"-2").style.display = "none";
	} else if(point>100) {
		var size = point*16/100;
		document.getElementById(image_id2).style.fontSize = size + 'px';
		document.getElementById(span_id+"-2").innerHTML = Math.round(point/100);
		document.getElementById(span_id+"-2").style.display = "block";
		document.getElementById(span_id+"-1").style.display = "none";
	} else {
		document.getElementById(image_id1).style.fontsize = '16px';
		document.getElementById(span_id+"-1").innerHTML = Math.abs(Math.round(point/100));
		document.getElementById(span_id+"-1").style.display = "block";
		document.getElementById(span_id+"-2").style.display = "block";
	}
	document.getElementById(span_id).innerHTML = Math.round(point/100);
};