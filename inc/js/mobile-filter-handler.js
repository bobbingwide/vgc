/**
 * Mobile filter handler for Search & Filter Pro v3.2
 *
 * Resets the fullscreen class when either the Reset or Show products button is clicked
 * and enables the logic to remove duplicates when the page is loaded.
 *
 */
const mobileFilterObserver = new MutationObserver((mutations) => {
    mutations.forEach((mutation) => {
        mutation.addedNodes.forEach((node) => {
            if (node.nodeType === 1) { // ELEMENT_NODE
                // If the node itself is a button
                if (node.matches('button')) {
                    mobileFilterAttachClickHandler(node);
                }

                // Or if it contains buttons inside
                const buttons = node.querySelectorAll?.('button');
                if (buttons && buttons.length) {
                    buttons.forEach(mobileFilterAttachClickHandler);
                }
            }
        });
    });
});

function mobileFilterAttachClickHandler(button) {
    // Avoid adding multiple identical listeners
    if (!button.dataset.customHandlerAttached) {
        button.addEventListener('click', () => {
            console.log('Button clicked:', button.textContent);
            document.querySelector('sidebar.shop-filter')?.classList.remove('fullscreen');
            vgcGetResultsHandler();

        });
        button.dataset.customHandlerAttached = 'true';
    }
}

// Look for buttons being added to the search and filter area.
const mobileFilterTargetNode = document.querySelector( 'div.searchandfilter');
if ( mobileFilterTargetNode ) {
    mobileFilterObserver.observe(mobileFilterTargetNode, {childList: true, subtree: true});
}