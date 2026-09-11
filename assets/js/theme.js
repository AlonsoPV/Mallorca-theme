(() => {
	const $ = (sel, ctx = document) => ctx.querySelector(sel);
	const $$ = (sel, ctx = document) => [...ctx.querySelectorAll(sel)];

	const trapFocus = (panel, closeBtn) => {
		const nodes = $$('a, button, input, select, textarea, [tabindex]:not([tabindex="-1"])', panel);
		if (!nodes.length) return;
		nodes[0].focus();
		panel.addEventListener('keydown', (e) => {
			if (e.key !== 'Tab') return;
			const first = nodes[0];
			const last = nodes[nodes.length - 1];
			if (e.shiftKey && document.activeElement === first) {
				e.preventDefault();
				last.focus();
			} else if (!e.shiftKey && document.activeElement === last) {
				e.preventDefault();
				first.focus();
			}
		});
	};

	const openLayer = (el) => {
		el.hidden = false;
		document.body.style.overflow = 'hidden';
		const panel = el.querySelector('[role="dialog"]') || el;
		const close = el.querySelector('[class*="close"]');
		trapFocus(panel, close);
	};

	const closeLayer = (el) => {
		el.hidden = true;
		document.body.style.overflow = '';
	};

	const header = $('.js-mallorca-header');
	if (header) {
		const onScroll = () => header.classList.toggle('is-compact', window.scrollY > 24);
		onScroll();
		window.addEventListener('scroll', onScroll, { passive: true });
	}

	const drawer = $('#mallorca-drawer');
	const cart = $('#mallorca-mini-cart');
	const search = $('#mallorca-search');

	$$('.js-mallorca-open-nav').forEach((b) => b.addEventListener('click', () => openLayer(drawer)));
	$$('.js-mallorca-close-nav').forEach((b) => b.addEventListener('click', () => closeLayer(drawer)));
	$$('.js-mallorca-open-cart').forEach((b) => b.addEventListener('click', () => openLayer(cart)));
	$$('.js-mallorca-close-cart').forEach((b) => b.addEventListener('click', () => closeLayer(cart)));
	$$('.js-mallorca-open-search').forEach((b) => {
		b.addEventListener('click', () => {
			openLayer(search);
			const input = $('.js-mallorca-search-input');
			if (input) input.focus();
		});
	});
	$$('.js-mallorca-close-search').forEach((b) => b.addEventListener('click', () => closeLayer(search)));

	[drawer, cart, search].forEach((layer) => {
		if (!layer) return;
		layer.addEventListener('click', (e) => {
			if (e.target === layer) closeLayer(layer);
		});
	});

	document.addEventListener('keydown', (e) => {
		if (e.key === 'Escape') {
			[drawer, cart, search].forEach((layer) => layer && !layer.hidden && closeLayer(layer));
		}
	});

	const filtersToggle = $('.js-mallorca-open-filters');
	const filters = $('.js-mallorca-filters');
	if (filtersToggle && filters) {
		filtersToggle.addEventListener('click', () => filters.classList.toggle('is-open'));
	}

	document.body.addEventListener('added_to_cart', () => {
		if (cart) openLayer(cart);
		const toast = $('.js-mallorca-toast');
		if (!toast || !window.mallorcaTheme) return;
		toast.textContent = mallorcaTheme.i18n.added;
		toast.hidden = false;
		requestAnimationFrame(() => toast.classList.add('is-visible'));
		clearTimeout(toast._hide);
		toast._hide = setTimeout(() => {
			toast.classList.remove('is-visible');
			setTimeout(() => {
				toast.hidden = true;
			}, 220);
		}, 2400);
	});

	const sticky = $('.js-mallorca-sticky-atc');
	if (sticky) {
		sticky.addEventListener('click', (e) => {
			const target = document.querySelector('#mallorca-add-to-cart .single_add_to_cart_button');
			if (target) {
				e.preventDefault();
				target.click();
			}
		});
	}

	const searchInput = $('.js-mallorca-search-input');
	const results = $('.js-mallorca-search-results');
	let timer = null;
	if (searchInput && results && window.mallorcaTheme) {
		searchInput.addEventListener('input', () => {
			clearTimeout(timer);
			const q = searchInput.value.trim();
			if (q.length < 2) {
				results.innerHTML = '';
				return;
			}
			timer = setTimeout(async () => {
				try {
					const res = await fetch(`${mallorcaTheme.restUrl}search?q=${encodeURIComponent(q)}`, {
						headers: { 'X-WP-Nonce': mallorcaTheme.nonce },
					});
					const data = await res.json();
					if (!data.length) {
						results.innerHTML = `<p class="mallorca-empty">${mallorcaTheme.i18n.noResults}</p>`;
						return;
					}
					results.innerHTML = data
						.map(
							(item) =>
								`<a class="mallorca-search-result" href="${item.url}"><img src="${item.image || ''}" alt="" width="64" height="64" /><span>${item.title}</span><strong>${item.price || ''}</strong></a>`
						)
						.join('');
				} catch (err) {
					results.innerHTML = '';
				}
			}, 220);
		});
	}

	const revealNodes = $$('.mallorca-reveal');
	if (revealNodes.length && 'IntersectionObserver' in window) {
		const io = new IntersectionObserver(
			(entries) => {
				entries.forEach((entry) => {
					if (!entry.isIntersecting) return;
					entry.target.classList.add('is-in');
					io.unobserve(entry.target);
				});
			},
			{ rootMargin: '0px 0px -8% 0px', threshold: 0.12 }
		);
		revealNodes.forEach((node) => io.observe(node));
	} else {
		revealNodes.forEach((node) => node.classList.add('is-in'));
	}
})();
