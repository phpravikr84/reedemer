jQuery(document).ready(function($){

	"use strict";

	var $rangeSlider = $(".days-slider-wrapper .slider");

	var slider = $rangeSlider.slider({
		range: true,     
		value: $rangeSlider.data('days-start'),
		min: $rangeSlider.data('days-start'),
		max: $rangeSlider.data('days-start-end'),
		step: 1,
		values: [ $rangeSlider.data('days-start-default'), $rangeSlider.data('days-end-default') ],

		slide: function(event, ui) {
			var values = $(event.target).slider( "option", "values" );
			$('.days-slider-left-number').text(values[0]);
			$('.days-slider-right-number').text(values[1]);

			$('[name="days_start_range"]').attr('value', values[0]);
			$('[name="days_end_range"]').attr('value', values[1]);
			$('.days-slider-left-number').text(values[0]);
			$('.days-slider-right-number').text(values[1]);

		},
		create: function(event, ui) {
			var values = $(event.target).slider( "option", "values" );
			$('[name="days_start_range"]').attr('value', values[0]);
			$('[name="days_end_range"]').attr('value', values[1]);
			$('.days-slider-left-number').text(values[0]);
			$('.days-slider-right-number').text(values[1]);

		}
	});

});