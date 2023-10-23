function slider(container, cardElem, prev, next){
  const slider = document.querySelector(container);
  const card = document.querySelector(cardElem);

  let isDragging = false;
  let startX;
  let startScrollLeft;

  if (!isExist(cardElem) && !isExist(slider)) return

  const cardWidth = card.offsetWidth + 32;

  addEvent(prev, 'click', () => slider.scrollLeft += -cardWidth);
  addEvent(next, 'click', () => slider.scrollLeft += cardWidth);

  addEvent(container, 'mousedown', (e) => {
    e.preventDefault();
  
    isDragging = true;
    startX = e.pageX;
    startScrollLeft = slider.scrollLeft;
  });

  addEvent(container, 'mousemove', (e) => {
    if (!isDragging) return;
    slider.scrollLeft = startScrollLeft - (e.pageX - startX);
  });

  addEvent(container, 'mouseup', () => {
    isDragging = false;
    slider.style.setProperty('cursor', 'auto');
  });
}

function isExist(target){
  const elements = document.querySelectorAll(target);
  return elements.length > 0 ? true : false;
}

function hasClass(target, style){
  if (!isExist(target)) return

  const element = document.querySelector(target);
  return element.classList.contains(style) ? true : false;
}

function addEvent(target, type = 'click', callback){
  if (!isExist(target)) return

  iterate(target, (element) => {
    element.addEventListener(type, callback);
  })
}

function dynamicStyle(target, style = 'active', type = 'add'){
  if (!isExist(target)) return

  iterate(target, (element) => {
    if (type === 'add') {
      element.classList.add(style)
    } else if (type === 'toggle') {
      element.classList.toggle(style);
    } else {
      element.classList.remove(style)
    }
  });
}

function iterate(target, callback){
  if (!isExist(target)) return

  const elements = document.querySelectorAll(target);
  elements.forEach((element, index) => callback(element, index));
}

function animate(target, keyframes, options){
  if (!isExist(target)) return

  const element = document.querySelector(target);
  element.animate(keyframes, options);
}

function removeClassFromChildrenInParent(target, callback){
  const parent = target.parentElement;
  callback(parent);
}

function updateQuantityCount(target, type = 'add'){
  const count = target.parentNode.querySelector('.shopping-cart__count');
  const countValue = parseInt(count.textContent.trim());

  if (type ===  'add') {
    count.textContent = countValue + 1;
  } else {
    count.textContent = countValue > 1 ? countValue - 1 : 1;
  }
}

function toggleAccountOption(showElement, hideElement, headingTxt, subHeadingTxt, type){
  if (type === 'signup') {
    dynamicStyle('.account__toggler');
  } else {
    dynamicStyle('.account__toggler', 'active', 'remove');
  }

  const heading = document.querySelector('.account__heading');
  const subHeading = document.querySelector('.account__subheading');
  const target = document.querySelector(showElement);
  const untarget = document.querySelector(hideElement);

  target.style.setProperty('display', 'block');
  untarget.style.setProperty('display', 'none');
  heading.textContent = headingTxt;
  subHeading.textContent = subHeadingTxt;
}

function appendChildElement(parent, element){
  if (!isExist(parent)) return

  const target = document.querySelector(parent);
  target.appendChild(element);
}

function toast(type, message){
  const icon = document.querySelector('.toast__icon');
  const messageTxt = document.querySelector('.toast__message');

  const defaultClassName = 'toast__icon';
  icon.className = type === 'success' ? `ri-checkbox-circle-fill ${defaultClassName}` : `ri-error-warning-fill ${defaultClassName}`;

  messageTxt.textContent = message;

  dynamicStyle('.toast', 'toast__smooth');
  dynamicStyle('.toast', type);

  setTimeout(() => {
    dynamicStyle('.toast', type, 'remove');
  }, 2500);
}

function previewUpload(e){
  const acceptedExtensions = ['image/jpeg', 'image/png', 'image/webp'];

  if (!acceptedExtensions.includes(e.target.files[0].type)) {
    toast('error', 'Invalid image extenstion')
  }

  const parent = e.target.parentNode;
  const imgPreview = parent.querySelector('.upload-preview');
  const icon = parent.querySelector('.upload-icon');

  const fileReader = new FileReader();

  fileReader.addEventListener('load', (e) => {
    imgPreview.removeAttribute('hidden');
    icon.style.setProperty('display', 'none');

    imgPreview.src = e.target.result;
  })

  fileReader.readAsDataURL(e.target.files[0]);
}

function createArrayContainer() {
  const array = [];

  return {
    addValue: function(value, valueIndex = null) {
      const index = array.indexOf(value);

      if (index !== -1) {
        array.splice(index, 1);
      } else {
        valueIndex !== null ? array[valueIndex] = value : array.push(value);
      }
    },
    addKeyAndValue: function(key, value) {
      array[key] = value;

      if(value === ''){
        delete array[key]
      }
    },
    getArray: function() {
      return array;
    },
    setFirstValue: function(value) {
      array[0] = value;
    },
    createArray: array
  };
}

function textTyping(selector, array){
  if(!isExist(selector)) return

  const typingSpeed = 100;
  let textIndex = 0;
  let charIndex = 0;

  const textElement = document.querySelector(selector);

  array.forEach((text, index) => {
    textElement.textContent += text.charAt(charIndex);
    charIndex++;
    
    textIndex = textIndex < array.length ? textIndex++ : 0;
  })
}

function disabled(elem, type){
  const btn = document.querySelector(elem);
  if (btn === null) return;
  type === "enabled" ? btn.removeAttribute('disabled')  : btn.setAttribute('disabled', '');
}

function resetUploads(formElement){
  const formUploads = formElement.querySelectorAll('.formdata__upload');
  formUploads.forEach(formUpload => {
    const imgPreview = formUpload.querySelector('.upload-preview');
    const uploadIcon = formUpload.querySelector('.upload-icon');
    imgPreview.setAttribute('hidden', '');
    uploadIcon.style.setProperty('display', 'flex');
  })
}

function resetSizesTickBox(formElement){
  const sizeTickBoxes = formElement.querySelectorAll('.formdata__tickbox');
  sizeTickBoxes.forEach(sizeTickBox => sizeTickBox.classList.remove('selected'));
}

function setShoeImages(datas){
  let $index = 0;
  const shoeImagePreview = document.querySelector('.view-product__overview');
  const viewShoeImages = document.querySelectorAll('.view-product__card img');

  for (const data of datas) {
    viewShoeImages[$index].src = `../../uploads/shoes/${data.shoe_image_id + data.extension}`;
    $index++;
  }

  const activeShoeImage = document.querySelector('.view-product__card.active img');
  shoeImagePreview.src = activeShoeImage.src;
}

function setTextContent(elem, text){
  if(!isExist(elem)) return
  const target = document.querySelector(elem);
  target.textContent = text;
}

function dialog(heading, subheading, action = 'show'){
  const docu = document.documentElement;
  const subHeading = document.querySelector('.dialog__subheading');
  subHeading.innerHTML = subheading;
  setTextContent('.dialog_heading', heading);

  if(action === 'show'){
    docu.style.setProperty('overflow-y', 'hidden');
    dynamicStyle('.dialog', 'show');
  } else {
    docu.style.setProperty('overflow-y', 'auto');
    dynamicStyle('.dialog', 'show', 'remove');
  }
}

function filter(callback, newFinders = null){
  const searchAreas = document.querySelectorAll('.search-area');

  searchAreas.forEach(searchArea => {
    const finders = searchArea.querySelectorAll('.finder1, .finder2, .finder3, .finder4, .finder5, .finder6, .finder7, .finder8');

    callback(newFinders !== null ? newFinders : finders, searchArea);
  });
}

function shouldHideElement(shouldHide, elem) {
  if (shouldHide) {
    elem.style.setProperty('display', 'none');
  } else {
    elem.style.setProperty('display', 'table-row');
  }
}

function search(value) {
  const matcher = new RegExp(value, 'i');
  filter((finders, searchArea) => {
    let shouldHide = true;
    finders.forEach(finder => {
      if (matcher.test(finder.textContent.trim())) {
        shouldHide = false;
      }
      shouldHideElement(shouldHide, searchArea);
    });
  })
}

function generateDownloadLink(data, filname){
  const dowloadLink = document.createElement('a');
  dowloadLink.setAttribute('href', URL.createObjectURL(data));
  dowloadLink.setAttribute('download', `${filname} Report.pdf`);
  dowloadLink.click();

  setTimeout(() => {
    dowloadLink.remove();
  }, 500);
}

function multipleFilters(filters){
  const searchAreas = document.querySelectorAll('.search-area');

  searchAreas.forEach(searchArea => {
    let matchFilterCount = 0;
    const brandFinder = searchArea.querySelector('.brand-finder');
    const categoryFinder = searchArea.querySelector('.category-finder');
    const genderFinder = searchArea.querySelector('.gender-finder');
    const priceFinder = searchArea.querySelector('.price-finder');
    const sizeFinder = searchArea.querySelector('.size-finder');
    const colorFinder = searchArea.querySelector('.color-finder');

    for (const key in filters) {
      if (key === 'brand' && brandFinder.dataset.value === filters[key]) {
        matchFilterCount++;
      } else if ((key === 'category' && categoryFinder.dataset.value === filters[key])) {
        matchFilterCount++;
      } else if ((key === 'gender' && genderFinder.dataset.value === filters[key])) {
        matchFilterCount++;
      } else if ((key === 'price')) {
        const price = parseInt(priceFinder.dataset.value);
        const values = filters[key].split('-');
        const secondCondition = values[1] === undefined ? price > values[0] : price <= values[1];
        if (price >= values[0] && secondCondition) {
          matchFilterCount++;
        }
      } else if ((key === 'size' && sizeFinder.dataset.value.includes(filters[key]))) {
        matchFilterCount++;
      } else {
        if (colorFinder.dataset.value.includes(filters[key])) {
          matchFilterCount++;
        }
      }
    }
    const shouldHide = matchFilterCount === Object.keys(filters).length ? false : true;
    shouldHideElement(shouldHide, searchArea);
  });
}

// function previewColor(){
//   const colorInputs = document.querySelectorAll('.formdata__color-input');

//   colorInputs.forEach(colorInput => {
//     colorInput.addEventListener('keyup', () => {
//       const parent = colorInput.parentNode;
//       const colorSpan = parent.querySelector('span');
      
//       if(colorInput.value === ''){
//         parent.remove();
//         return
//       }
    
//       colorSpan.style.background = colorInput.value.trim();
//     })
//   })
// }

export { slider, isExist, hasClass, addEvent, dynamicStyle, iterate, animate, removeClassFromChildrenInParent, updateQuantityCount, toggleAccountOption, appendChildElement, toast, previewUpload, createArrayContainer, textTyping, disabled, resetUploads, resetSizesTickBox, setShoeImages, dialog, filter, search, generateDownloadLink, shouldHideElement, multipleFilters };