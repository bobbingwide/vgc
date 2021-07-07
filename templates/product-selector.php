<?php
$options = get_field('product_addons'); ?>
<form action="" method="post">
     <section class="options-size options pb-5">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <h1 class="w-100 clearfix font-weight-bold mb-4 font-colour-primary text-center">Choose your size</h1>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12 d-flex">
            <?php for($i = 0; $i < count($options); $i++) { ?>
              <div class="p-5 block text-center">
                <p class="font-weight-bold mb-0"><?php echo $options[$i]['size']; ?></p>
                <input type="checkbox" name="size" value="<?php echo $options[$i]['price']; ?>">
              </div>
            <?php } ?>
          </div>
      </div>
    </section>
  </form>
