/**
 * Get results handler
 *
 * Responds to the `get-results/start` and/or `get-results/finish` hook to
 * 1. remove duplicate products in the products list
 * 2. reset the first and last class names in the products list to group into rows of 4.
 */

let vgcResultsHandling = false;

function vgcGetResultsHandler() {
    if (vgcResultsHandling) {
        return;
    }
    vgcResultsHandling = true;
    vgcAttachResultsHandler();

}

function vgcAttachResultsHandler() {

    const queries = window.searchAndFilter.frontend.queries.getAll();

    for (let i = 0; i < queries.length; i++) {
        const query = queries[i];

        // Get the query ID.
        //console.log(query.getId());
        // Get query attributes using getAttribute
        //console.log(query.getAttribute('postTypes'));
        //console.log(query.getAttribute('resultsDynamicUpdate'));
        if (query.getAttribute('resultsDynamicUpdate') === 'yes') {
            // Listen for the update to the results.
            query.on('get-results/start', function (queryObject) {
                console.log("Start getting results.");
            });

            // Listen for the update to the results.
            query.on('get-results/finish', function (queryObject) {
                console.log("Finished getting results.");
                vgcCheckDuplicateProducts();
                reClassifyProducts();

            });
        }
    }

}

function vgcCheckDuplicateProducts() {
    console.log( 'Checking duplicate products');
    const listItems = document.querySelectorAll('div.vgc_products li.product' );
    listItems.forEach((li, index) => {
        //console.log(li);
        if (!li.classList.contains('processed')) {
            // Your processing logic here
            console.log('Processing:', li.innerText);
            checkDuplicateNode( li );

            // Mark as processed
            li.classList.add('processed');
        }
    });
}