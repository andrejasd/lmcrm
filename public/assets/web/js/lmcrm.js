$(function(){
	if ($.isFunction($.fn.selectBoxIt)) {
	    $("select").selectBoxIt();
	}

	if ($.isFunction($.fn.datepicker)) {
		$(".datepicker").each(function (i, el) {
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
		$(".validate").validate();
	}

	$(".dialog").click(function(){
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

	if ($.isFunction($.fn.DataTable)) {
		$('.dataTable').DataTable({
			responsive: true
		});
	}

	$('.ajax-dataTable').each(function() {
		$table=$(this);
		$container=$table.closest('.dataTables_container');
		var dTable = $table.DataTable({
			"destroy": true,
			"searching": false,
			"lengthChange": false,
			"processing": true,
			"serverSide": true,
			"ajax": {
				"data": function (d) {
					var filter = {};
					$container.find(".dataTables_filter").each(function () {
						if ($(this).data('name') && $(this).data('js') != 1) {
							filter[$(this).data('name')] = $(this).val();
						}
					});
					d['filter'] = filter;
				},
			}
		});
		$container.find(".dataTables_filter").change(function () {
			if ($(this).data('js') == '1') {
				switch ($(this).data('name')) {
					case 'pageLength':
						if ($(this).val()) dTable.page.len($(this).val()).draw();
						break;
					default:
						;
				}
			} else {
				dTable.ajax.reload();
			}
		});
		$container.delegate('.ajax-link', 'click', function () {
			var href = $(this).attr('href');
			$.ajax({
				url: href,
				method: 'GET',
				success: function () {
					dTable.ajax.reload();
				}
			});
			return false;
		});
		dTable.ajax.reload();
	});
});