$(function(){
	if ($.isFunction($.fn.selectBoxIt)) {
		$("select").selectBoxIt();
	}

	if ($.isFunction($.fn.datepicker)) {
		$(".ajax-content .datepicker").each(function (i, el) {
			var $this = $(el),
					opts = {
						format: $this.attr('format') || 'mm/dd/yyyy',
						startDate:  $this.attr('startDate') || '',
						endDate:  $this.attr( 'endDate') || '',
						daysOfWeekDisabled:  $this.attr('disabledDays') || '',
						startView:  $this.attr('startView') || 0,
					},
					$n = $this.next();
			$this.datepicker(opts);
			if ($n.is('.input-group-addon') && $n.has('a')) {
				$n.on('click', function (ev) {
					ev.preventDefault();
					$this.datepicker('show');
				});
			}
		});
	}
	if ($.isFunction($.fn.validate)) {
		$(".ajax-content .validate").validate();
	}

	$(".ajax-content .dialog").click(function(){
		var href=$(this).attr("href");
		$.ajax({
			url:href,
			success:function(response){
				var dialog = bootbox.dialog({
					message:response,
					show: false
				});
				dialog.on("show.bs.modal", function() {
					$(this).find('.ajax-form').ajaxForm(function() {
						dialog.modal('hide');
					});
				});
				dialog.modal("show");
			}
		});
		return false;
	});
});