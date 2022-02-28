import noUiSlider from "nouislider";
import './styles/app.css';
import 'nouislider/dist/nouislider.css'
import flatpickr from "flatpickr";
import {French} from "flatpickr/dist/l10n/fr.js"
import "flatpickr/dist/flatpickr.css"
import Filter from './modules/Filter'

new Filter(document.querySelector('.js-filter'))

let slider = document.getElementById('price-slider');

if (slider) {
	const min = document.getElementById('minPrice')
	const max = document.getElementById('maxPrice')

	const minValue = Math.floor(parseInt(slider.dataset.min, 10) / 10) * 10
	const maxValue = Math.ceil(parseInt(slider.dataset.max, 10) / 10) * 10

	const range = noUiSlider.create(slider, {
		start: [min.value || minValue, max.value || maxValue],
		connect: true,
		step: 1000,
		range: {
			'min': minValue,
			'max': maxValue
		}
	});

	range.on('slide', function (values, handle) {
		if (handle === 0) {
			min.value = Math.round(values[0])
		}

		if (handle === 1) {
			max.value = Math.round(values[1])
		}
	})

	range.on('end', function (values, handle) {
		min.dispatchEvent(new Event('change'))
	})
}

const showingDate = flatpickr('.flatpickrDate', {
	enableTime: false,
	dateFormat: "Y-m-d H:i",
	altInput: true,
	altFormat: "j F Y",
	locale: French
})
