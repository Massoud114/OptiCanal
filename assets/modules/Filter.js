import {Flipper, spring} from "flip-toolkit";

/**
 * @property {HTMLElement} pagination
 * @property {HTMLElement} sorting
 * @property {HTMLElement} content
 * @property {HTMLFormElement} form
 */
export default class Filter {

	/**
	 * @param {HTMLElement|null} element
	 */
	constructor(element) {
		if (element == null) {
			return
		}
		this.pagination = element.querySelector('.js-filter-pagination')
		this.content = element.querySelector('.js-filter-content')
		this.sorting = element.querySelector('.js-filter-sorting')
		this.form = element.querySelector('.js-filter-form')

		this.bindEvents()
	}

	bindEvents() {

		const clickerListener = e => {
			if (e.target.tagName === "A") {
				e.preventDefault()
				this.loadUrl(e.target.getAttribute('href'))
			}
		}

		this.sorting.addEventListener('click', clickerListener)

		this.pagination.addEventListener('click', clickerListener)

		this.form.querySelectorAll('input').forEach(input => {
			input.addEventListener('change', this.loadForm.bind(this))
		})
	}

	async loadForm() {
		const data = new FormData(this.form)
		const url = new URL(this.form.getAttribute('action') || window.location.href)
		const params = new URLSearchParams()
		data.forEach((value, key) => {
			params.append(key, value)
		})
		return this.loadUrl(url.pathname + '?' + params.toString())
	}

	async loadUrl(url) {
		const ajaxUrl = url + '&ajax=1'
		const response = await fetch(ajaxUrl, {
			headers: {
				'X-Requested-With': 'XMLHttpRequest'
			}
		})
		if (response.status >= 200 && response.status < 300) {
			const data = await response.json()
			this.flipContent(data.content)
			this.sorting.innerHTML = data.sorting
			this.pagination.innerHTML = data.pagination
			history.replaceState({}, '', url)
		} else {
			console.error(response)
		}
	}

	flipContent(content) {
		const springWord = 'veryGentle'
		const exitSpring = function (element, index, complete) {
			spring({
				config: springWord,
				values: {
					translateX: [-50, 0],
					opacity: [1, 0]
				},
				onUpdate: ({translateX, opacity}) => {
					element.style.opacity = opacity
					element.style.transform = `translateX${translateX}px`;
				},
				onComplete: complete
			})
		}

		const appearSpring = function (element, index) {
			spring({
				config: springWord,
				values: {
					translateX: [50, 0],
					opacity: [0, 1]
				},
				onUpdate: ({translateX, opacity}) => {
					element.style.opacity = opacity
					element.style.transform = `translateX${translateX}px`;
				},
				delay: index * 5
			})
		}

		const flipper = new Flipper({
			element: this.content
		})

		Array.from(this.content.children).forEach(element => {
			flipper.addFlipped({
				element,
				spring: springWord,
				flipId: element.id,
				shouldFlip: false,
				onExit: exitSpring
			})
		})
		flipper.recordBeforeUpdate()
		this.content.innerHTML = content
		Array.from(this.content.children).forEach(element => {
			flipper.addFlipped({
				element,
				spring: springWord,
				flipId: element.id,
				onAppear: appearSpring
			})
		})
		flipper.update()
	}
}
