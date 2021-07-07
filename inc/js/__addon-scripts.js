// Run this function on page load and add any required fields to the current cart session
(function setupDefaultAddons() {
  var section = document.querySelectorAll('.section-addon-wrap .addon-select-required');
  var blocks  = [];
  for(var i = 0; i < section.length; i++) {
    blocks = section[i].querySelectorAll(".block");
    var currentCartSessionContainer = document.querySelector(".current-cart-session .items");
    // Lets see if there is a select box as the first
    var select = blocks[0].querySelector('select');
    if(select) {
      select.selectedIndex = 1;
      var addonID = select.name;
      var addonPrice = parseFloat(select[1].attributes[1].nodeValue).toFixed(2);
      var addonName = blocks[0].querySelector('.addon-name').innerText;
      addAddonItemToCartSession(currentCartSessionContainer, addonID, addonPrice, addonName);
    }
    else {
	  
      var addonPrice = parseFloat(blocks[0].querySelector('.addon-price .price').textContent).toFixed(2);
      //var addonName = blocks[0].querySelector('.addon-name').innerText;
      var addonName = blocks[0].querySelector('.addon-name').textContent;      
      var addonID = blocks[0].querySelector('.checkbox-container input[type="checkbox"]').name;

      addAddonItemToCartSession(currentCartSessionContainer, addonID, addonPrice, addonName);
    }
  }
  
  //toggle each section as hidden first then show
  var acc = document.getElementsByClassName("toggle-next");
  var i;
  for (i = 0; i < acc.length; i++) {
    acc[i].addEventListener("click", function() {
      this.classList.toggle("active");
      var panel = this.nextElementSibling;
      if (panel.style.maxHeight) {
        panel.style.maxHeight = null;
      } else {
        panel.style.maxHeight = panel.scrollHeight + "px";
      }
    });
  }  
  
})();

//---- Code for calculating the addons added to the current cart session ---/
function addAddonToCart(event, type) {
  // On click of the checkbox get the container to add addon items to
  var currentCartSessionContainer = document.querySelector(".current-cart-session .items");
  // Get the addon name
  var addonName = event.target.parentNode.parentNode.querySelector('.addon-name').innerText;
  // Check if this section is a required section
  var currentSection = event.target.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode;
  // Get all the class names for the element and then convert to array
  var list = currentSection.classList;
  var array = [];
  for(var i = 0; i < list.length; i++) {
    array.push(list[i]);
  }
  // Check if the class name exists in the array // If true -> this is a required section
  // required OR select one only (lik radio)
  if (array.indexOf('addon-select-required') > -1 || (array.indexOf('addon-select-radio') > -1)) {
    dealWithRequiredAddons(currentSection, event);
  }
  // Get the addon price
  if(type == "checkbox") {
    var addonPrice = parseFloat(event.target.parentNode.parentNode.querySelector('.addon-price .price').innerText).toFixed(2);
    // Get the addon ID
    var addonID = event.target.name;
    // If we are checking the checkbox add it to the current cart session list
    if(event.target.checked == true) {
      var item = currentCartSessionContainer.querySelector('#'+stripRandChar(addonID));
      if(!item) {
        addAddonItemToCartSession(currentCartSessionContainer, addonID, addonPrice, addonName);
      }
    }
    // Else we are removing it from the cart session list
    else {
      removeAddonItemFromCartSession(addonID, addonPrice);
    }
  }
  else {
    // It's a select box, lets get the price from the custom attribute
    dealWithMultiSelectBoxAddons(event, currentCartSessionContainer, addonName);
  }
}

function dealWithMultiSelectBoxAddons(event, currentCartSessionContainer, addonName) {
  var element = event.target;
  var index = event.target.selectedIndex;
  var addonID = event.target.name;
  
  //console.log(addonID);
  //console.log(stripRandChar(addonID));  
  
  var item = document.querySelector(".current-cart-session .items #"+stripRandChar(addonID));
  if(item) {
    addonPrice = item.querySelector(".price").innerText;
    addonPrice = addonPrice.replace("£", "");
    addonPrice = parseFloat(addonPrice).toFixed(2);
    
    removeAddonItemFromCartSession(addonID, addonPrice);
  }
  if(index > 0) {
    var addonPrice = parseFloat(event.target[index].attributes[1].nodeValue);
    addAddonItemToCartSession(currentCartSessionContainer, addonID, addonPrice, addonName);
  }
}

function addAddonItemToCartSession(currentCartSessionContainer, addonID, addonPrice, addonName) {
  // Create the list item for the current cart session
  var itemToAdd = "<div class='text-left w-100 clearfix'><div id="+stripRandChar(addonID)+" class='d-flex minilist'><div class='minilist__name'>"+addonName+"</div><div class='price minilist__price'>£"+parseFloat(addonPrice).toFixed(2)+"</div></div></div>";
  // Insert the list item
  currentCartSessionContainer.insertAdjacentHTML('beforeend', itemToAdd);
  // Get the current subtotal or base price field
  var currentPriceField = document.querySelector(".baseprice");
  var currentPrice = parseFloat(currentPriceField.innerText).toFixed(2);
  // Calculate the total
  var total = parseFloat(currentPrice) + parseFloat(addonPrice);
  // Reinsert the total
  currentPriceField.innerText = parseFloat(total).toFixed(2);
}



function dealWithRequiredAddons(currentSection, event) {
  // Get all the checkboxes
  var checkboxes = currentSection.querySelectorAll('.addon-details input[type="checkbox"]');
  // Lets first loop through all the checkboxes
    for(var i = 0; i < checkboxes.length; i++) {
      // Unchecked all section checkboxes and then check the clicked checkbox
      // Find out which checkbox WAS checked
      if(checkboxes[i].checked == true && checkboxes[i] !== event.target) {
        // We now know which checkbox WAS checked
        var addonPrice = parseFloat(checkboxes[i].parentNode.parentNode.querySelector('.addon-price .price').innerText).toFixed(2);
        var addonID = checkboxes[i].name;
        removeAddonItemFromCartSession(addonID, addonPrice);
      }
      // Set all the checkboxes to false
      checkboxes[i].checked = false;
      event.target.checked = true;
    }
    // Now deal with any select boxes in the required addons section
    // Lets get all select boxes
    var select = currentSection.querySelectorAll('.addon-details select');
    for(var i = 0; i < select.length; i++) {
      if(select[i] !== event.target && select[i].selectedIndex > 0) {
        // Unset it so there is no option choosen
        var addonID = select[i].name;
        var index = select[i].selectedIndex;
        select[i].selectedIndex = 0;
        var addonPrice = parseFloat(select[i][index].attributes[1].nodeValue);
        removeAddonItemFromCartSession(addonID, addonPrice);
      }
  }
}

function removeAddonItemFromCartSession(addonID, addonPrice) {

  // Get the current subtotal or base price field
  var currentPriceField = document.querySelector(".baseprice");
  var currentPrice = parseFloat(currentPriceField.innerText);
  // Calculate the total
  var total = parseFloat(currentPrice).toFixed(2) - parseFloat(addonPrice).toFixed(2);
  // Reinsert the total
  currentPriceField.innerText = parseFloat(total).toFixed(2);



  // Remove the list item and subtract the price
  var listItem = document.querySelector('.current-cart-session .items #'+stripRandChar(addonID));
  if(listItem) {
    listItemParent = listItem.parentNode;
    while(listItemParent.firstChild) {
      listItemParent.removeChild(listItemParent.firstChild);
    }
  }
}




// Strip any random characters that are going to affect dom selection
function stripRandChar(addonID) {
  var pattern = /[&|:|/|(|)|*|%|'|]/g;
  var newID = addonID.replace(pattern, "");
  return newID;
}



