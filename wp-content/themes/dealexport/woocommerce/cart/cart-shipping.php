<?php
/*
@version 3.0.0
*/

if (!defined('ABSPATH')) {
  exit;
}
$delivery_zones = WC_Shipping_Zones::get_zones();
?>
<section class="checkout-delivery-section checkout-section">
  <h5 class="section-title title"><span class="section-order">3</span><?php _e('DELIVERY METHOD', 'dealexport'); ?></h5>
  <div class="woocommerce-shipping-methods section-content content">
    <?php
    foreach ((array) $delivery_zones as $key => $the_zone) {
      foreach ($the_zone['shipping_methods'] as $value) {
        echo $value->id;
        if ($value->id == 'flat_rate') {
    ?>
          <div class="checkout-delivery-option">
            <div class="checkout-delivery-option-icon">
              <span class="custom-radio float-xs-left">
                <input type="radio" name="delivery_option[175]" id="delivery_option_9" value="9," checked="">
                <span></span>
              </span>
              <span class="checkout-delivery-image">
                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAAAXNSR0IArs4c6QAABSpJREFUaAXtWFkodV8UX2TKPBMhmQmJeFHGeBJCeKKEF0NkiFAeUEK+JMMDD6ZERBEeJEnmsUjKTCgSIcL5ztpf53Rc5957ruF//+mu2vfsvfbaa+/fXmvtvddVenh4oOAXkPIvwEAgKID83yypsIjCIj+0AwrX+qGN/bRahUU+vXU/NPDXWERFyAbFxcXByMiIEFHBMioqKtDR0QGRkZGCx0gSFARkbW0NzM3NITw8XJIuwX13d3cwMDAA29vb/y0QXKGjoyM0NTUJXqwkwf39fQJEkoysfYIsIqtSofK7u7swNjbGK25sbAw+Pj68fXxMuQLp6ekBLOIoLS0NampqAONJGkmXkKbhC/0xMTGAhY96e3uhtbWVxFF3dzcYGRnxibE8QUBwR1RVVdlB31VxcXGBqKgoXnV4mlVUVEBlZSX4+/tDf38/uLm58coiUxCQP3/+gKGhoVglX+0YGhqC2dnZd2o8PDygpKQEXF1dAV0sMDAQ2traICIi4p0c05AKpL29HRAIRUlP7WNjY6G0tJTRLfibn58PJycnH+QXFxehrq4O7O3tAe+y+Ph4qKqqguzs7A+yUm92XV1d4p/oo9KKvr7+hwmEMN7e3oj7XF5eApbT01Nyv2CMJCYmgrOzM8zMzBDrlJWV8aqUahFJAcmr8ZNMjENtbW12dFdXF2RmZgJ6BL4qoqOjwdPTkwQ/K8SpSASyt7cH9N9FoKSkBMrKyuTLrTM8tISBgQFH7derqBtdFYHgGpDQvXF+PhILZG5uDoKDg/nGfODhiXZwcPDtYEQnQheUGYiXlxd5kuC7CHeCW1AhtpmviYnJj4NAUDgnWoqPxFpEXV0dkpKS+MZ8Ow93eXp6GszMzN7pfnl5IW3GCgiEqb8TpBu8QEZHR8UGFVcBulRCQgKYmppy2TLXCwoKYGpqinecpqYmBAUFkT6ZXSsnJweOj495FYsy9fT0vmy51NRUwCKEZHKtpaUluLi4YPVeX18DupqWlhbLwwpaxMbG5h3vJxsyu5aOjg5gYcjPz4/crni2y5MkAeE/AkRWixa5uroS4f5rPj8/w/r6umBX5FXCYT4+PsLKygqcn59zuP+qGCMyudYHDTTj5uYGJicnARMefNAhdXZ2Ql5eHtze3pK2r68vucBsbW3JJbawsECOaNLJ+WEWiRcu6nRwcAArKyuor6+H8vJyeHp6ItKYWre0tJA58V7DceJOLZyQklboNBdfjGyhLz9qeHiYtOmnOFVbW0vl5uZSampqFP3UpmjQFP0QZOW5Y/nqqL+5uZnI05tB0YCo9PR0it59ij6xqPHxcVaXpaUl73p5j1+yHZwfTHI2NjYIBy2Cx21jYyPgg3JiYoJNevAeKCwsJA+8rKwsYjl0B2mEj8KUlBSwtrYmqa+GhgYZQm8MNDQ0QHV1NQwODsL9/T1gDsNHgoA4OTkBFi4dHR2BnZ0dCwL7vL29iQj24fNGXPbH1cPUDw8PISAgABgQyGf0nZ2dSf0HR1CwM5Nxvxgnm5ubsLq6yrKZ/Nvd3Z3lCa2gPrzdERASWrKvr4/UJWWGRID+UcL4YBqyfDFQ8Vh+fX2FsLAwkkMsLy+T1BVzbFlpfn4eQkNDyV0VEhICOzs7sLW1BRkZGcS1pOn7NBBUjJMVFRUBnij4jMcsrri4GNC3P0OYEWKGiVa2sLCA5ORkkpOIO3K5c3wJCFeRvOufjhF5L1x0fgUQ0R2Rd1thEXlbQHR+hUVEd0TebYVF5G0B0fl/jUX+AnYUH/sbj7YBAAAAAElFTkSuQmCC" />
              </span>
              <span class="checkout-delivery-name">
                LIVRAISON À DOMICILE
              </span>
              <span class="checkout-delivery-des">
                2-5 jours ouvrés
              </span>
              <span class="checkout-delivery-fee">
                <?php
                echo apply_filters('woocommerce_get_shipping_flat_rate', null);
                ?>
              </span>
            </div>
          </div>
    <?php }
      }
    }
    ?>
  </div>
</section>