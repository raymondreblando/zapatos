import { 
  slider, 
  isExist, 
  hasClass, 
  addEvent, 
  dynamicStyle, 
  iterate, 
  animate, 
  removeClassFromChildrenInParent, 
  updateQuantityCount, 
  toggleAccountOption, 
  appendChildElement, 
  toast, 
  previewUpload, 
  createArrayContainer, 
  disabled, 
  resetUploads, 
  resetSizesTickBox, 
  setShoeImages, 
  dialog,
  filter, 
  search,
  generateDownloadLink,
  shouldHideElement,
  multipleFilters
} 
from "./function.js";

import request from './utils.js';
 
const sizeContainer = createArrayContainer();
const colorContainer = createArrayContainer();
const mopContainer = createArrayContainer();
const actionContainer = createArrayContainer();
const filtersContainer = createArrayContainer();

const observer = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if(!entry.isIntersecting) return

    iterate('.header__link', (link) => {
      if(entry.target.getAttribute('id') !== link.dataset.target) return

      dynamicStyle('.header__link', 'active', 'remove');
      link.classList.add('active');
    })
  })
}, { threshold: 0.50 })

window.addEventListener('scroll', () => {
  if(scrollY > 0){
    dynamicStyle('header', 'sticky');
    dynamicStyle('.product-wrapper__header', 'sticky');
    dynamicStyle('.product-wrapper__filters', 'sticky');
    dynamicStyle('.view-product__showcase', 'sticky');
    dynamicStyle('.shopping-cart__shipping', 'sticky');
  } else{
    dynamicStyle('header', 'sticky', 'remove');
    dynamicStyle('.product-wrapper__header', 'sticky', 'remove');
    dynamicStyle('.product-wrapper__filters', 'sticky', 'remove');
    dynamicStyle('.view-product__showcase', 'sticky', 'remove');
    dynamicStyle('.shopping-cart__shipping', 'sticky', 'remove');
  } 

  iterate('section', (section) => observer.observe(section));
})

window.addEventListener('DOMContentLoaded', () => {
  if(isExist('.formdata__update-tickbox')){
    iterate('.formdata__update-tickbox', (tickbox) => {
      sizeContainer.addValue(tickbox.dataset.value.trim());
    })
  }

  if(isExist('.view-product__colors--btn')){
    const selectedColor = document.querySelector('.view-product__colors--btn.active');
    colorContainer.addValue(selectedColor.dataset.value.trim(), 0);
  }
})

addEvent('body', 'click', () => {
  if(isExist('.nav__notification-dropdown')){
    dynamicStyle('.nav__notification-dropdown', 'show', 'remove');
  }
})

addEvent('.header__show--btn i', 'click', ({ target }) => {
  if(hasClass('header', 'sticky')){
    dynamicStyle('header', 'sticky', 'remove');
  }

  target.className = target.className === 'ri-menu-4-line' ? 'ri-close-line' : 'ri-menu-4-line';

  dynamicStyle('header', 'sticky', 'toggle');
  dynamicStyle('.header__menu', 'show', 'toggle');
})

addEvent('.hero__card', 'click', ({ target }) => {
  dynamicStyle('.hero__card', 'active', 'remove');
  target.classList.add('active');

  const heroImage = document.querySelector('.hero__shoe--image');
  const cardImage = target.querySelector('img');
  heroImage.src = cardImage.src;

  animate('.hero__shoe--image', {
    opacity: ['0%', '100%'],
    transform: ['translateY(150px) rotate(-24deg)', 'translateY(0) rotate(-24deg)']
  }, {
    duration: 700,
    easing: 'ease',
    fill: 'forwards'
  })
})

slider('.product__slider', '.product__card', '.prev-btn', '.next-btn');

addEvent('.product-wrapper__list li', 'click', ({ target }) => {
  removeClassFromChildrenInParent(target, (parent) => {
    const lists = parent.querySelectorAll('li');
    lists.forEach(list => list.classList.remove('active'));
    target.classList.add('active');
  })
})

addEvent('.product-wrapper__catalog-header', 'click', ({ target }) => {
  const parent = target.parentElement;
  const ul = parent.querySelector('ul');
  if(ul.style.display === '' || ul.style.display === 'block'){
    ul.style.display = 'none';
  } else{
    ul.style.display = 'block';
  }
  console.log(ul.style.display);
})

addEvent('.product-wrapper__checkbox', 'click', ({ target }) => {
  if(target.classList.contains('checked')){
    target.classList.remove('checked');
    return
  } 
  
  removeClassFromChildrenInParent(target, (parent) => {
    const checkboxes = parent.querySelectorAll('.product-wrapper__checkbox');
    checkboxes.forEach(checkbox => checkbox.classList.remove('checked'));
    target.classList.add('checked');
  })
})

addEvent('.product-wrapper__tickbox', 'click', ({ target }) => {
  if(target.classList.contains('selected')){
    target.classList.remove('selected');
    return
  } 
  
  dynamicStyle('.product-wrapper__tickbox', 'selected', 'remove');
  target.classList.add('selected');
})

addEvent('.product-wrapper__radio', 'click', ({ target }) => {
  if(target.classList.contains('active')){
    target.classList.remove('active');
    return
  } 
  
  dynamicStyle('.product-wrapper__radio', 'active', 'remove');
  target.classList.add('active');
})

addEvent('.product-wrapper__filter--btn', 'click', () => {
  const filter = document.querySelector('.product-wrapper__filters');

  if(filter.style.display === '' || filter.style.display === 'none'){
    filter.style.display = 'grid';
  } else{
    filter.style.display = 'none';
  }
})

addEvent('.view-product__card', 'mouseover', ({ target }) => {
  const image = target.querySelector('img');
  const preview = document.querySelector('.view-product__overview');
  preview.src = image.src;

  dynamicStyle('.view-product__card', 'active', 'remove');
  target.classList.add('active');
})

addEvent('.view-product__colors--btn', 'click', ({ target }) => {  
  colorContainer.addValue(target.dataset.value.trim(), 0);
  console.log(colorContainer.getArray());
  dynamicStyle('.view-product__colors--btn ', 'active', 'remove');
  target.classList.add('active');
})

addEvent('.view-product__tickbox', 'click', ({ target }) => {
  if(target.classList.contains('selected')){
    target.classList.remove('selected');
    sizeContainer.addValue(target.dataset.value.trim());
    return
  } 
  
  sizeContainer.addValue(target.dataset.value.trim(), 0);
  dynamicStyle('.view-product__tickbox', 'selected', 'remove');
  target.classList.add('selected');
})

iterate('[data-rating]', (rating, index) => {
  const ratings = document.querySelectorAll('[data-rating]');
  const ratingInput = document.querySelector('.review__rating--input');

  rating.addEventListener('click', ({ target }) => {
    const nextIndex = index < ratings.length - 1 ? index + 1 : index;
      if(index !== 0 && !rating.previousElementSibling.classList.contains('ri-star-fill')) return;

      if(index !== 4 && ratings[nextIndex].classList.contains('ri-star-fill')) return;
      
      if(target.classList.contains('ri-star-fill')){
        target.className = 'ri-star-line'
      } else{
        target.className = 'ri-star-fill'
      }
      
      const filled = document.querySelectorAll('.ri-star-fill');
      ratingInput.value = filled.length;
  })
})

addEvent('.shopping-cart__tickbox', 'click', ({ currentTarget }) => {
  dynamicStyle('.shopping-cart__tickbox', 'active', 'remove');
  currentTarget.classList.add('active');
  mopContainer.addValue(currentTarget.dataset.value.trim(), 0);
})

addEvent('.password-show', 'click', ({ currentTarget }) => {
  const icon = currentTarget.querySelector('i');
  const parent = currentTarget.parentNode;
  const input = parent.querySelector('input');

  if(input.type === 'password'){
    icon.className = 'ri-eye-off-fill';
    input.type = 'text';
  } else{
    icon.className = 'ri-eye-fill';
    input.type = 'password';
  }
})

addEvent('.account__signin--btn', 'click', () => {
  toggleAccountOption(
    '.account__signin-form', 
    '.account__signup-form', 
    'Sign In to Your Account',
    'Access your profile and enjoy a seamless shopping experience',
    'signin'
  )
})

addEvent('.account__signup--btn', 'click', () => {
  toggleAccountOption(
    '.account__signup-form', 
    '.account__signin-form', 
    'Create Your Account',
    'Join our community for exclusive offers and seamless shopping',
    'signup'
  )
})

addEvent('.nav__show-sidebar--btn', 'click', () => {
  animate('aside', {
    left: 0,
    visibility: 'visible',
    opacity: '100%'
  }, {
    duration: 250,
    easing: 'ease-in-out',
    fill: 'forwards'
  })
})

addEvent('.aside__hide--btn', 'click', () => {
  animate('aside', {
    left: '-50%',
    visibility: 'hidden',
    opacity: '0%'
  }, {
    duration: 250,
    easing: 'ease-in-out',
    fill: 'forwards'
  })
})

addEvent('.nav__show-search--btn', 'click', ({ currentTarget }) => {
  currentTarget.style.display = 'none';

  const searchBar = document.querySelector('.searchbar');
  searchBar.style.display = 'flex';
})

addEvent('.nav__notifications', 'click', (e) => {
  e.stopPropagation();
  dynamicStyle('.nav__notification-dropdown', 'show');
})

addEvent('.formdata__upload', 'click', ({ currentTarget }) => {
  const uploadInput = currentTarget.querySelector('.upload-input');
  uploadInput.click();
})

addEvent('.upload-input', 'change', (e) => {
  previewUpload(e);
})

addEvent('.formdata__add--btn', 'click', () => {
  const wrapper = document.createElement('div');
  wrapper.className = 'formdata__color';
  const span = document.createElement('span');
  const input = document.createElement('input');
  input.setAttribute('type', 'text');
  input.setAttribute('name', 'colors[]');
  input.setAttribute('placeholder', 'HEX Code');

  wrapper.appendChild(span);
  wrapper.appendChild(input);

  appendChildElement('.formdata__color-grid', wrapper);
})

addEvent('.formdata__tickbox', 'click', ({ currentTarget }) => {
  currentTarget.classList.toggle('selected');
  sizeContainer.addValue(currentTarget.dataset.value.trim());
})

addEvent('.formdata__size--toggle-btn', 'click', () => {
  dynamicStyle('.formdata__tickbox', 'selected');

  iterate('.formdata__tickbox', (tickbox) => sizeContainer.addValue(tickbox.dataset.value.trim()));
})

addEvent('.formdata__color-input', 'keyup', ({ target }) => {
  const parent = target.parentNode;
  const colorSpan = parent.querySelector('span');

  if(target.value === ''){
    parent.remove();
    return
  }

  colorSpan.style.background = target.value.trim();
})

addEvent('.account__google--btn', 'click', () => {
  const googleBtn = document.querySelector('#google-btn');
  googleBtn.click();
})

addEvent('.account__facebook--btn', 'click', () => {
  toast('error', 'An error occured');
})

addEvent('.close--btn', 'click', () => {
  dialog('', '', 'hide');
})

addEvent('#search-input', 'keyup', ({ target }) => {
  search(target.value)
})

addEvent('.select-filter', 'change', ({ target }) => {
  const type = target.dataset.type;
  filtersContainer.addKeyAndValue(type, target.value.trim());

  const filters = [];
  const filterArray = filtersContainer.getArray();

  for (const key in filterArray) {
    filters.push(filterArray[key]);
  }

  filter((finders, searchArea) => {
    let shouldHide = !filters.every(filter => {
      return Array.from(finders).some(finder => finder.textContent.trim() === filter);
    });
    shouldHideElement(shouldHide, searchArea);
  })
})

addEvent('#date-filter', 'change', ({ target }) => {
  search(target.value);
})

addEvent('.date-start', 'change', ({ target }) => {
  search(target.value);
})

addEvent('.date-end', 'change', ({ target }) => {
  const startDateInput = document.querySelector(".date-start");
  const finders = document.querySelectorAll('.date-value');


  if (startDateInput.value === '') {
    target.value = '';
    toast('error', 'Select start date');
    return
  }

  const startDate = new Date(startDateInput.value);
  const endDate = new Date(target.value);

  filter((finders, searchArea) => {
    let shouldHide = true; 
    finders.forEach(finder => {
      const finderDate = new Date(finder.textContent.trim());
      if (finderDate >= startDate && finderDate <= endDate) {
        shouldHide = false;
      }
    })
    shouldHideElement(shouldHide, searchArea);
  }, finders)
})

addEvent('.brand-filter', 'click', ({ currentTarget }) => {
  filtersContainer.addKeyAndValue('brand', currentTarget.dataset.value.trim());

  const filters = filtersContainer.getArray();
  multipleFilters(filters);
})

addEvent('.category-filter', 'click', ({ currentTarget }) => {
  filtersContainer.addKeyAndValue('category', currentTarget.dataset.value.trim());

  const filters = filtersContainer.getArray();
  multipleFilters(filters);
})

addEvent('.gender-filter', 'click', ({ currentTarget }) => {
  filtersContainer.addKeyAndValue('gender', currentTarget.dataset.value.trim());

  const filters = filtersContainer.getArray();
  multipleFilters(filters);
})

addEvent('.price-filter', 'click', ({ currentTarget }) => {
  filtersContainer.addKeyAndValue('price', currentTarget.dataset.value.trim());

  const filters = filtersContainer.getArray();
  multipleFilters(filters);
})

addEvent('.size-filter', 'click', ({ currentTarget }) => {
  filtersContainer.addKeyAndValue('size', currentTarget.dataset.value.trim());

  const filters = filtersContainer.getArray();
  multipleFilters(filters);
})

addEvent('.color-filter', 'click', ({ currentTarget }) => {
  filtersContainer.addKeyAndValue('color', currentTarget.dataset.value.trim());
  
  const filters = filtersContainer.getArray();
  multipleFilters(filters);
})

//HTTP Request
addEvent('#newsletter-form', 'submit', (e) => {
  e.preventDefault();
  disabled('#newsletter-btn', 'disabled');

  request('app/Jobs/process_saving_subscriber.php', () => {
    e.target.reset();
  }, { 
    data: new FormData(e.target), 
    type: 'create', 
    button: '#newsletter-btn'
  })
})

addEvent('#signup-form', 'submit', (e) => {
  e.preventDefault();
  disabled('#signup-btn', 'disabled');

  request('app/Jobs/process_account_register.php', () => {
    e.target.reset();
    setTimeout(() => {
      location.href = 'http://localhost/projects/zapatos/email/verification';
    }, 2500);
  }, { 
    data: new FormData(e.target), 
    type: 'create', 
    button: '#signup-btn'
  })
})

addEvent('#signin-form', 'submit', (e) => {
  e.preventDefault();
  disabled('#signin-btn', 'disabled');

  request('app/Jobs/process_account_login.php', () => {}, 
  { 
    data: new FormData(e.target), 
    type: 'auth', 
    button: '#signin-btn'
  })
})

addEvent('#save-brand-form', 'submit', (e) => {
  e.preventDefault();
  disabled('#save-brand-btn', 'disabled');

  request('app/Jobs/process_saving_brand.php', () => {
    e.target.reset();
    setTimeout(() => {
      location.reload();
    }, 2500);
  }, { 
    data: new FormData(e.target), 
    type: 'create', 
    button: '#save-brand-btn'
  })
})

addEvent('#save-category-form', 'submit', (e) => {
  e.preventDefault();
  disabled('#save-category-btn', 'disabled');

  request('app/Jobs/process_saving_category.php', () => {
    e.target.reset();
    setTimeout(() => {
      location.reload();
    }, 2500);
  }, { 
    data: new FormData(e.target), 
    type: 'create', 
    button: '#save-category-btn'
  })
})

addEvent('#save-shoe-form', 'submit', (e) => {
  e.preventDefault();
  disabled('#save-shoe-btn', 'disabled');

  const formData = new FormData(e.target);
  formData.append('sizes', sizeContainer.getArray());

  request('../app/Jobs/process_saving_shoe.php', () => {
    e.target.reset();
    resetUploads(e.target);
    resetSizesTickBox(e.target);
  }, { 
    data: formData, 
    type: 'create',
    button: '#save-shoe-btn'
  })
})

addEvent('#update-shoe-form', 'submit', (e) => {
  e.preventDefault();
  const shoeId = e.target.querySelector('#update-shoe-btn').dataset.value;
  disabled('#update-shoe-btn', 'disabled');

  const formData = new FormData(e.target);
  formData.append('shoe_id', shoeId);
  formData.append('sizes', sizeContainer.getArray());

  request('../../app/Jobs/process_updating_shoe.php', () => {}, 
  { 
    data: formData, 
    type: 'update',
    button: '#update-shoe-btn'
  })
})

addEvent('.update__color-status', 'click', ({ target }) => {
  const value = target.dataset.value;

  request('../../app/Jobs/process_updating_color_status.php', () => {
    setTimeout(() => {
      location.reload();
    }, 2500);
  }, { 
    data: `color_id=${value}`, 
    type: 'update',
    button: null,
    headers: { 
      'Content-Type': 'application/x-www-form-urlencoded'
    }
  })
})

iterate('.shoe__image-form', (shoeImageForm) => {
  shoeImageForm.addEventListener('submit', (e) => {
    e.preventDefault();
    const submitBtn = e.target.querySelector('.save-shoe-image__btn');

    const formData = new FormData(e.target);
    formData.append('color_id', submitBtn.dataset.value.trim());

    request('../../app/Jobs/process_saving_shoe_images.php', () => {
      setTimeout(() => {
        location.reload();
      }, 2500);
    }, { 
      data: formData, 
      type: 'create',
      button: null
    })
  })
})

addEvent('#change-order-status', 'click', ({ currentTarget }) => {
  disabled('#change-order-status', 'disabled');
  const value = currentTarget.dataset.value;
  const status = currentTarget.dataset.status;

  if (status === 'Ship Out') {
    fetch('../../app/Jobs/process_updating_order_status.php', {
      method: 'POST',
      body: `order_id=${value}&status=${status}`,
      headers: { 
        'Content-Type': 'application/x-www-form-urlencoded'
      }
    })
    .then(res => res.blob())
    .then(data => {
      Fancybox.show([
        {
          src: URL.createObjectURL(data),
          type: "pdf",
          preload: false,
          width: 1800,
          height: 980,
          on: {
            close: () => location.reload()
          }
        }
      ])

      disabled('#change-order-status', 'enabled');
    })
  } else {
    request('../../app/Jobs/process_updating_order_status.php', () => {
      setTimeout(() => {
        location.reload();
      }, 2500);
    }, { 
      data: `order_id=${value}&status=${status}`, 
      type:  'update',
      button: '#change-order-status',
      headers: { 
        'Content-Type': 'application/x-www-form-urlencoded'
      }
    })
  }
})

addEvent('.account-action--btn', 'click', ({ currentTarget }) => {
  actionContainer.addValue(currentTarget.dataset.value, 0);
  const heading = 'Account Status';
  const subheading = `You are about to update the account status of customer named <span>${currentTarget.dataset.target}</span>. This action can affect the customer account.`;
  dialog(heading, subheading);

  addEvent('.confirm--btn', 'click', () => {
    const value = actionContainer.getArray()[0] !== undefined ? actionContainer.getArray()[0] : '';

    request('../app/Jobs/process_updating_account_status.php', () => {
      setTimeout(() => {
        location.reload();
      }, 2500);
    }, { 
      data: `account_id=${value}`, 
      type: 'update',
      button: null,
      headers: { 
        'Content-Type': 'application/x-www-form-urlencoded'
      }
    })
  })
})

addEvent('#generate-form', 'submit', (e) => {
  e.preventDefault();
  disabled('#generate-btn', 'disabled');

  request('../app/Jobs/process_generating_report.php', () => {
    setTimeout(() => {
      location.reload();
    }, 2500);
  }, { 
    data: new FormData(e.target), 
    type: 'update',
    button: '#generate-btn'
  })
})

addEvent('.button--print', 'click', ({ currentTarget }) => {
  const value = currentTarget.dataset.value;

  fetch('../app/Jobs/process_fetching_report_data.php', {
    method: 'POST',
    body: `report_id=${value}`,
    headers: { 
      'Content-Type': 'application/x-www-form-urlencoded'
    }
  })
  .then(res => res.blob())
  .then(data => {
    Fancybox.show([
      {
        src: URL.createObjectURL(data),
        type: "pdf",
        preload: false,
        width: 1800,
        height: 980
      }
    ])
  })
})

addEvent('.button--download', 'click', ({ currentTarget }) => {
  const value = currentTarget.dataset.value;
  const filename = currentTarget.dataset.date;

  fetch('../app/Jobs/process_fetching_report_data.php', {
    method: 'POST',
    body: `report_id=${value}`,
    headers: { 
      'Content-Type': 'application/x-www-form-urlencoded'
    }
  })
  .then(res => res.blob())
  .then(data => generateDownloadLink(data, filename))
})

addEvent('#save-general-setting-form', 'submit', (e) => {
  e.preventDefault();
  disabled('#save-general-setting-btn', 'disabled');

  request('app/Jobs/process_saving_settings.php', () => {}, 
  { 
    data: new FormData(e.target), 
    type: 'create',
    button: '#save-general-setting-btn'
  })
})

addEvent('.nav__notification-wrapper', 'click', ({ currentTarget }) => {
  const value = currentTarget.dataset.value;
  const SYSTEM_URL = 'http://localhost/projects/zapatos/';

  request(`${SYSTEM_URL}app/Jobs/process_updating_notification_status.php`, (url) => {
    location.href = url;
  }, { 
    data: `notification_id=${value}`, 
    type: 'fetch',
    button: null,
    headers: { 
      'Content-Type': 'application/x-www-form-urlencoded'
    }
  })
})

addEvent('.view-product__colors--btn', 'click', ({ target }) => {
  const value = target.dataset.value;

  request('../../app/Jobs/process_fetching_shoe_images.php', (datas) => {
    setShoeImages(JSON.parse(datas));
  }, { 
    data: `color_id=${value}`, 
    type: 'fetch',
    button: null,
    headers: { 
      'Content-Type': 'application/x-www-form-urlencoded'
    }
  })
})

addEvent('.email-verify', 'click', () => {
  request('../../app/Jobs/process_redirecting_success_verification.php', () => {}, 
  { 
    data: null, 
    type: 'auth',
    button: null
  })
})

addEvent('.view-product__addcart--btn', 'click', ({ currentTarget }) => {
  disabled('.view-product__addcart--btn', 'disabled');
  const value = currentTarget.dataset.value;
  const selectedColor = colorContainer.getArray();
  const selectedSize = sizeContainer.getArray();

  const formData = new FormData();
  formData.append('shoe_id', value);
  formData.append('color_id', selectedColor[0] === undefined ? '' : selectedColor[0]);
  formData.append('size_id', selectedSize[0] === undefined ? '' : selectedSize[0]);

  request('../../app/Jobs/process_saving_cart_item.php', () => {
    setTimeout(() => {
      location.reload();
    }, 2500);
  }, { 
    data: formData, 
    type: 'create',
    button: '.view-product__addcart--btn'
  })
})

addEvent('.view-product__addwish--btn', 'click', ({ currentTarget }) => {
  disabled('.view-product__addwish--btn', 'disabled');
  const value = currentTarget.dataset.value;
  const selectedColor = colorContainer.getArray();
  const selectedSize = sizeContainer.getArray();

  const formData = new FormData();
  formData.append('shoe_id', value);
  formData.append('color_id', selectedColor[0] === undefined ? '' : selectedColor[0]);
  formData.append('size_id', selectedSize[0] === undefined ? '' : selectedSize[0]);

  request('../../app/Jobs/process_saving_wishlist_shoe.php', () => {
    setTimeout(() => {
      location.reload();
    }, 2500);
  }, { 
    data: formData, 
    type: 'create',
    button: '.view-product__addwish--btn'
  })
})

addEvent('.wishlist-wrapper__action--remove-btn', 'click', ({ currentTarget }) => {
  actionContainer.addValue(currentTarget.dataset.value, 0);
  const heading = 'Remove Shoe';
  const subheading = `You are about to remove the shoe <span>${currentTarget.dataset.target}</span> from your wishlist. This action will permanently remove it from wishlist.`;
  dialog(heading, subheading);

  addEvent('.confirm--btn', 'click', () => {
    const value = actionContainer.getArray()[0] !== undefined ? actionContainer.getArray()[0] : '';

    request('app/Jobs/process_deleting_wishlist_shoe.php', () => {
      setTimeout(() => {
        location.reload();
      }, 2500);
    }, { 
      data: `wishlist_id=${value}`, 
      type: 'delete',
      button: null,
      headers: { 
        'Content-Type': 'application/x-www-form-urlencoded'
      }
    })
  })
})

addEvent('.shopping-cart__action--minus-btn', 'click', ({ currentTarget }) => {
  const value = currentTarget.dataset.value;
  updateQuantityCount(currentTarget, 'minus');

  request('app/Jobs/process_updating_cart_item_quantity.php', () => {
    location.reload();
  }, { 
    data: `cart_id=${value}&type=minus`, 
    type: 'fetch',
    button: null,
    headers: { 
      'Content-Type': 'application/x-www-form-urlencoded'
    }
  })
})

addEvent('.shopping-cart__action--add-btn', 'click', ({ currentTarget }) => {
  const value = currentTarget.dataset.value;
  updateQuantityCount(currentTarget);

  request('app/Jobs/process_updating_cart_item_quantity.php', () => {
    location.reload();
  }, { 
    data: `cart_id=${value}&type=add`, 
    type: 'fetch',
    button: null,
    headers: { 
      'Content-Type': 'application/x-www-form-urlencoded'
    }
  })
})

addEvent('#save-shipping-form', 'submit', (e) => {
  e.preventDefault();
  disabled('#save-shipping-btn', 'disabled');

  request('app/Jobs/process_saving_shipping_details.php', () => {}, 
  { 
    data: new FormData(e.target), 
    type: 'create',
    button: '#save-shipping-btn'
  })
})

addEvent('#checkout-form', 'submit', (e) => {
  e.preventDefault();
  disabled('#checkout-btn', 'disabled');
  const selectedPaymentMethod = mopContainer.getArray();

  request('app/Jobs/process_order_checkout.php', () => {
    setTimeout(() => {
      location.reload();
    }, 2550);
  }, { 
    data: `mop=${selectedPaymentMethod[0] === undefined ? '' : selectedPaymentMethod[0]}`, 
    type: 'create',
    button: '#checkout-btn',
    headers: { 
      'Content-Type': 'application/x-www-form-urlencoded'
    }
  })
})

addEvent('.order__cancel--btn', 'click', ({ currentTarget }) => {
  actionContainer.addValue(currentTarget.dataset.value, 0);
  const heading = 'Cancel Order';
  const subheading = `You are about to cancel your order with order no <span>${currentTarget.dataset.target}</span>. This action will permanently cancel your order.`;
  dialog(heading, subheading);

  addEvent('.confirm--btn', 'click', () => {
    const value = actionContainer.getArray()[0] !== undefined ? actionContainer.getArray()[0] : '';

    request('../app/Jobs/process_cancelling_customer_order.php', () => {
      setTimeout(() => {
        location.reload();
      }, 2500);
    }, { 
      data: `order_id=${value}&status=Cancelled`, 
      type: 'update',
      button: null,
      headers: { 
        'Content-Type': 'application/x-www-form-urlencoded'
      }
    })
  })
})

addEvent('#save-review-form', 'submit', (e) => {
  e.preventDefault();
  disabled('#save-review-btn', 'disabled');

  request('../app/Jobs/process_saving_customer_review.php', () => {
    iterate('[data-rating]', (rating) => rating.className = 'ri-star-line');
    e.target.reset();
  }, { 
    data: new FormData(e.target), 
    type: 'create',
    button: '#save-review-btn'
  })
})