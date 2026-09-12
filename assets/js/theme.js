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
	const stickyBar = $('.js-mallorca-sticky-bar');
	const purchaseBlock = $('#mallorca-purchase');
	const atcBtn = $('#mallorca-add-to-cart .single_add_to_cart_button');
	const footer = $('.mallorca-footer');

	if (sticky && atcBtn) {
		sticky.addEventListener('click', (e) => {
			e.preventDefault();
			atcBtn.click();
		});
	}

	const stickyTarget = purchaseBlock || atcBtn;

	if (stickyBar && stickyTarget && 'IntersectionObserver' in window && window.matchMedia('(max-width: 900px)').matches) {
		let atcVisible = true;
		let footerVisible = false;
		const syncSticky = () => {
			const show = !atcVisible && !footerVisible && !!atcBtn && !atcBtn.disabled;
			stickyBar.hidden = !show;
			stickyBar.classList.toggle('is-visible', show);
		};
		const atcIo = new IntersectionObserver(
			([entry]) => {
				atcVisible = entry.isIntersecting;
				syncSticky();
			},
			{ threshold: 0.12, rootMargin: '0px 0px -8% 0px' }
		);
		atcIo.observe(stickyTarget);
		if (footer) {
			const footIo = new IntersectionObserver(
				([entry]) => {
					footerVisible = entry.isIntersecting;
					syncSticky();
				},
				{ rootMargin: '0px 0px -10% 0px', threshold: 0 }
			);
			footIo.observe(footer);
		}
	}

	$$('.js-mallorca-qty').forEach((btn) => {
		btn.addEventListener('click', () => {
			const wrap = btn.closest('.quantity');
			const input = wrap && wrap.querySelector('input.qty');
			if (!input) return;
			const step = parseFloat(input.step || '1') || 1;
			const min = input.min !== '' ? parseFloat(input.min) : 0;
			const max = input.max !== '' ? parseFloat(input.max) : Infinity;
			const dir = parseInt(btn.getAttribute('data-dir') || '1', 10);
			let next = (parseFloat(input.value) || 0) + dir * step;
			if (next < min) next = min;
			if (next > max) next = max;
			input.value = String(next);
			input.dispatchEvent(new Event('change', { bubbles: true }));
		});
	});

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

	/**
	 * Keep external fixed widgets (WPCafe location, sticky ATC, etc.)
	 * from covering footer content. Lifts them by measured footer overlap;
	 * hides only when lift would push the control off-screen.
	 */
	const FLOAT_SELECTORS = [
		'.wpc-floating-location',
		'.mallorca-sticky-atc',
		'.mallorca-float-aware',
		'.woofc-floating-cart',
		'.xoo-wsc-basket',
	];

	const collectFloatWidgets = () =>
		FLOAT_SELECTORS.flatMap((sel) => {
			try {
				return $$(sel);
			} catch (err) {
				return [];
			}
		}).filter((el, i, arr) => {
			if (!el || arr.indexOf(el) !== i) return false;
			const pos = getComputedStyle(el).position;
			return pos === 'fixed' || pos === 'sticky' || el.classList.contains('wpc-floating-location');
		});

	const readFloatBaseBottom = (el) => {
		const inline = el.style.bottom;
		el.style.bottom = '';
		const computedBottom = getComputedStyle(el).bottom;
		el.style.bottom = inline;
		const parsed =
			computedBottom && computedBottom !== 'auto' ? parseFloat(computedBottom) : NaN;
		return Number.isFinite(parsed) ? parsed : 20;
	};

	const syncFloatingAboveFooter = () => {
		const footer = $('.mallorca-footer');
		if (!footer) return;

		const widgets = collectFloatWidgets();
		if (!widgets.length) return;

		const vh = window.innerHeight || document.documentElement.clientHeight;
		const footerTop = footer.getBoundingClientRect().top;
		const clearance = 16;
		const overlap = Math.max(0, vh - footerTop + clearance);

		widgets.forEach((el) => {
			el.classList.add('mallorca-float-aware');

			if (overlap <= 0) {
				el.style.bottom = '';
				el.classList.remove('is-footer-hidden');
				delete el.dataset.mallorcaFloatBase;
				return;
			}

			if (el.dataset.mallorcaFloatBase == null) {
				el.dataset.mallorcaFloatBase = String(readFloatBaseBottom(el));
			}

			const base = parseFloat(el.dataset.mallorcaFloatBase) || 20;
			const nextBottom = base + overlap;
			const elHeight = el.getBoundingClientRect().height || 64;
			const wouldLeaveViewport = nextBottom + elHeight > vh - 8;

			if (wouldLeaveViewport) {
				el.classList.add('is-footer-hidden');
				el.style.bottom = `${base}px`;
				return;
			}

			el.classList.remove('is-footer-hidden');
			el.style.bottom = `${nextBottom}px`;
		});
	};

	const bindFloatingFooterGuard = () => {
		const footer = $('.mallorca-footer');
		if (!footer) return;

		let ticking = false;
		let dirty = false;

		const schedule = () => {
			dirty = true;
			if (ticking) return;
			ticking = true;
			requestAnimationFrame(() => {
				ticking = false;
				if (!dirty) return;
				dirty = false;
				syncFloatingAboveFooter();
				if (dirty) schedule();
			});
		};

		const onResize = () => {
			collectFloatWidgets().forEach((el) => {
				delete el.dataset.mallorcaFloatBase;
				el.style.bottom = '';
				el.classList.remove('is-footer-hidden');
			});
			schedule();
		};

		window.addEventListener('scroll', schedule, { passive: true });
		window.addEventListener('resize', onResize, { passive: true });

		if ('IntersectionObserver' in window) {
			const io = new IntersectionObserver(schedule, {
				root: null,
				threshold: [0, 0.01, 0.1, 0.25, 0.5, 0.75, 1],
			});
			io.observe(footer);
		}

		// WPCafe may inject the floating widget after first paint.
		const mo = new MutationObserver((mutations) => {
			const added = mutations.some((m) =>
				[...m.addedNodes].some(
					(n) =>
						n.nodeType === 1 &&
						(n.matches?.('.wpc-floating-location') || n.querySelector?.('.wpc-floating-location'))
				)
			);
			if (added) schedule();
		});
		mo.observe(document.body, { childList: true, subtree: true });
		setTimeout(() => mo.disconnect(), 10000);

		schedule();
	};

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', bindFloatingFooterGuard);
	} else {
		bindFloatingFooterGuard();
	}
})();
