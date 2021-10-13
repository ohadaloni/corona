/*------------------------------------------------------------*/
$(function() {
	coronaPaintRows(document);
	/*	$(".imgToolTip").imgToolTip();	*/
	$(".showImage").showImage();
});
/*------------------------------------------------------------*/
function coronaPaintRows(context)
{
	$(".mRow", context).hoverClass("hilite");
	$(".coronaRow", context).hoverClass("hilite");
	$(".mFormRow", context).hoverClass("hilite");
	$(".mHeaderRow", context).addClass("coronaZebra0");
	$(".coronaHeaderRow", context).addClass("coronaZebra0");
	$(".mFormRow:nth-child(odd)", context).addClass("coronaZebra1");
	$(".mFormRow:nth-child(even)", context).addClass("coronaZebra2");
	$(".mRow:nth-child(odd)", context).addClass("coronaZebra1");
	$(".mRow:nth-child(even)", context).addClass("coronaZebra2");
	$(".coronaRow:nth-child(odd)", context).addClass("coronaZebra2");
	$(".coronaRow:nth-child(even)", context).addClass("coronaZebra1"); // first row is 1
	$(".coronaFormRow:nth-child(odd)", context).addClass("coronaZebra2");
	$(".coronaFormRow:nth-child(even)", context).addClass("coronaZebra1"); // first row is 1

	$(".today:nth-child(odd)", context).addClass("coronaZebra3");
	$(".today:nth-child(even)", context).addClass("coronaZebra4");
	$(".yesterday:nth-child(odd)", context).addClass("coronaZebra5");
	$(".yesterday:nth-child(even)", context).addClass("coronaZebra6");
	$(".coronaRow", context).click(function(){
		$(".coronaRow").not(this).removeClass("keepHilited");
		$(this).addClass("keepHilited");
	});

}
/*------------------------------------------------------------*/
