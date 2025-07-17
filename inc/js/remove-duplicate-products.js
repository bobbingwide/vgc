/**
 * Removes duplicate products after Load more.
 *
 * The code attaches a MutationObserver callback function to detect changes to the product list.
 * For each product added it checks to see if it's a duplicate.
 * This is determined by the presence of the newly added products URL in the drop down list of each product ranges' Size options.
 * If the URL appears more than once then this is a duplicate, so can be deleted.
 * At the end of the processing we adjust the first and last classes on the products list items to allow
 * CSS to correctly group the products in rows of 4; when the window width allows it.
 *
 */

// Look for new products being added to the list.
const duplicateProductsTargetNode = document.querySelector( 'div.vgc_products ul.products');

// Set up the observer configuration
// Don't monitor attributes since we change these during processing.
const duplicateProductsConfig = { childList: true, subtree: true, attributes: false };

/**
 * Caters for added mutations.
 *
 * Callback function to execute when mutations are observed.
 *
 * @TODO The code is not yet optimised... reClassifyProducts can get called more than once
 * since it doesn't cater for the removedNodes which come in a second mutation list.
 */
const duplicateProductsCallback = function(mutationsList) {
    //console.log( mutationsList );
    let removed = false;
    for (let mutation of mutationsList) {
        //console.log( mutation );
        if (mutation.type === 'childList') {
            mutation.addedNodes.forEach(node => {
                //console.log( node);
                if (node.tagName === 'LI') {
                    //console.log('A LI product was added!', node);
                    removed = checkDuplicateNode( node ) || removed;

                }
            });
        } else if ( mutation.type === ' attributes') {
            console.log( 'attribute change');
        }
    }
    if ( removed ) {
        reClassifyProducts();
    }

};

/**
 * Checks for duplicate node by finding the product's URL in another product's Sizes dropdown.
 *
 * @param node
 */
function checkDuplicateNode( node ) {
    var removed = false;
    //console.log( 'Checking for duplicate node');
    const href = findCurrentNodesHref( node );
    const matches = countMatchingNodes( href );
    if ( matches > 1 ) {
        //console.log( "This is a duplicate");
        deleteNode( node );
        removed = true;
    }
    return removed;
}

function findCurrentNodesHref( node ) {
    const link = node.querySelector('div.product-attributes h3 a');
    const href = link ? link.getAttribute('href') : null;
    //console.log(href);
    return href;
}

function countMatchingNodes( href ) {
    const matchingNodes = document.querySelectorAll(`div.vgc_products li.product div.dropdown li.dropdown-item a[href="${href}"]`);
    const count = matchingNodes.length;
    console.log(`Found ${count} link(s) with href="${href}"`);
    return count;
}

/**
 * Deletes the duplicate product.
 *
 * Let's hope we don't go recursive doing this!
 *
 * @param node
 */
function deleteNode( node ) {
    node.remove();
}

/**
 * Resets the first and last classes on the product list in groups of 4 per row.
 *
 */
function reClassifyProducts() {

    const listItems = document.querySelectorAll('div.vgc_products li.product' );
    console.log( 'Reclassifying products:' + listItems.length);
    listItems.forEach((li, index) => {
        // Clear existing classes
        li.classList.remove('first', 'last');

        const positionInGroup = index % 4;

        if (positionInGroup === 0) {
            li.classList.add('first');
        } else if (positionInGroup === 3) {
            li.classList.add('last');
        }
    });
}

// Create an observer instance
const duplicateProductsObserver = new MutationObserver( duplicateProductsCallback );

// Start observing
duplicateProductsObserver.observe( duplicateProductsTargetNode, duplicateProductsConfig );