<?php
/*========================== WOOCOMMERCE CUSTOMIZATION ==========================*/
/**
 * Thêm phần thông tin cho các sản phẩm có custom attribute là "deal"
 */
//function amagumo_display_additional_message_for_deal() {
//	global $product;
//	if( ($product -> get_attributes())['pa_deal']['options'][0] == 145) { // TODO: không nên so sánh với term_id là 145 vì rất khó hiểu :)) code lại cho dễ hiểu :))
//		echo '<div class="additional-message"><span>This is a deal! Special Discount and Offers information shall be put here.</span></div><br>';
//	}
//}
//add_action( 'woocommerce_single_product_summary', 'amagumo_display_additional_message_for_deal', 99 );


/**
 * Thêm nhãn "Deal" màu đỏ vào các sản phẩm có custom attribute là "deal"
 */
//function display_the_badges_for_deals() {
//	global $product;
//	if( ($product -> get_attributes())['pa_deal']['options'][0] == 145) { // TODO: không nên so sánh với term_id là 145 vì rất khó hiểu :)) code lại cho dễ hiểu :))
//		echo '<div class="deal-badge-background"></div>';
//		echo '<div class="deal-badge-text">DEAL</div>';
////		echo $product -> post -> post_excerpt;
//	}
//}
//add_action( 'woocommerce_before_shop_loop_item_title', 'display_the_badges_for_deals', 10 );


// function dump_product_attributes() {
//     global $product;
//     echo ( the_ID() . ' (Product code)<br>' );
//     $product_attributes = $product -> get_attributes();
//     echo '<pre>';
//     print_r($product_attributes);
//     echo '</pre>';
// }
// add_action( 'woocommerce_single_product_summary', 'dump_product_attributes', 100);


/*========================== DATABASE MANIPULATING ==========================*/
/**
 * Trả về các posts có custom attribute cụ thể
 * @param $attr là string có tên của custom attribute cần query
 * @author Mark
 * @return array|bool|object|null
 */
//function amagumo_query_custom_attribute($attr) {
//	global $wpdb;
//	$sql = "
//      SELECT
//        *
//      FROM
//        db_posts,
//        db_term_relationships,
//        db_term_taxonomy
//      WHERE
//	    db_posts.ID = db_term_relationships.object_id
//	  AND
//        db_term_relationships.term_taxonomy_id = db_term_taxonomy.term_id
//	  AND
//        db_term_taxonomy.taxonomy = 'pa_" . $attr . "'";
//	return $wpdb->get_results($sql);
//}

/**
 * Trả về danh sách các ID của các posts thỏa nhiều điều kiện slug: OR nếu cùng taxonomy, AND nếu khác taxonomy
 * @param $master_array mảng chứa các mảng con $sub_array, mỗi mảng con chứa các string là các slug có chung một taxonomy
 * @author Amagumo Team
 * @return array|bool|object|null
 */
function amagumo_query_filter($master_array) {
    global $wpdb;
    $count = ""; // thêm phần COUNT vào câu query database
    $having = ""; // thêm phần HAVING vào phần HAVING của câu query database
    if($master_array != null) {
        foreach ($master_array as $master_key => $sub_array) { // duyệt qua tất cả các slug của param truyền vào hàm
            reset($master_array); // trả pointer của $master_array về vị trí đầu tiên để check xem phần tử đang duyệt có phải là phần tử đầu tiên không
            if( $sub_array != NULL ) {
                foreach ($sub_array as $sub_key => $slug) {
                    reset($sub_array); // trả pointer của $sub_array về vị trí đầu tiên để check xem phần tử đang duyệt có phải là phần tử đầu tiên không
                    $count = $count . ", COUNT( CASE WHEN db_term_relationships.term_taxonomy_id = ( SELECT db_terms.term_id FROM db_terms WHERE slug = '" . $slug . "' ) THEN 1 ELSE NULL END ) AS count" . str_replace('-', '', $slug); // thực hiện COUNT các record có slug là $slug, record nào thỏa thì tạo COLUMN mới tên "count[slug]" và đánh dấu bằng giá trị 1, không thỏa trả về NULL
                    if( $sub_key === key($sub_array) ) {
                        if( $master_key === key($master_array)) {
                            $having = $having . "HAVING ( count" . str_replace('-', '', $slug) . " >= 1 "; // nếu duyệt qua slug đầu tiên trong mảng $sub_array VÀ mảng $sub_array này cũng là mảng đầu tiên của $master_array thì thêm đoạn "HAVING ( count" cho slug đầu tiên
                        }
                        else {
                            $having = $having . "AND ( count" . str_replace('-', '', $slug) . " >= 1 "; // nếu duyệt qua slug đầu tiên trong mảng $sub_array NHƯNG mảng này ko phải là mảng đầu tiên trong $master_array thì là đang duyệt tới một taxonomy mới, truyền vào "AND ( count" cho slug đầu tiên của taxonomy hiện tại
                        }
                    } else {
                        $having = $having .  "OR count" . str_replace('-', '', $slug) . " >= 1 "; // nếu slug đang duyệt không phải slug đầu tiên của cả $sub_array và $master_array thì là đang duyệt tới một slug thứ 2 trở đi của một nhóm taxonomy, truyền vào "OR ( count" cho slug này của taxonomy hiện tại
                    }
                    end($sub_array); // đưa pointer về vị trí cuối cùng
                    if( $sub_key === key($sub_array)) {
                        $having = $having . " ) "; // kiểm tra xem slug đang duyệt có phải là slug cuối cùng của $sub_array không, nếu có thì thêm dấu đóng ngoặc " ) " trong câu query sql
                    }
                }
            }
            end($master_array); // đưa pointer về vị trí cuối cùng của $master_array
//			if ( $master_key === key($master_array) ) {
//			    echo 'Làm gì khi duyệt tới hết?';
//			}
        }
    } else {
        return false;
    }
    $sql = "SELECT filter_result.object_id FROM (SELECT db_term_relationships.object_id" . $count . " FROM db_term_relationships GROUP BY db_term_relationships.object_id " . $having . ") filter_result;"; // nên debug để xem giá trị của biến $sql sau khi thực hiện xong hàm để dễ hiểu hơn :'(

    // dùng $temp_array hứng tạm các kết quả để chuyển ra array luôn cho khỏe
    $temp_array = $wpdb->get_results($sql); // $temp_array nhận các kết quả trả về dạng là 1 mảng, mỗi mảng có 1 object và phải gọi tới prop "object_id" nữa mới lấy được id => mệt! :)) lấy sẵn luôn cho khỏe rồi trả ra cho hàm
    $result_array = array();
    foreach ($temp_array as $temp_item) {
        array_push($result_array, $temp_item->object_id);
    }
    return $result_array; // kết quả trả ra chỉ là array chứa các id
}

/*========================== POPUP PANEL ==========================*/
/**
 * Khung hiển thị để xem một số thông tin cho dev
 * Hiện tại đang gây conflict
 */
//function display_popup_panel() {
//	echo '<div id="popup-panel" style="display: block; position: fixed; z-index: 10; overflow: scroll; top: 50%; left: 50%; width: 50%; height: 50%; transform: translate(-50%, -50%); background-color: rgba(59, 59, 59, 0.6); color: white">' . '</div>';
//	echo "<button id='popup-button' style='position: fixed; z-index: 10; bottom: 0; right: 0; background-color: var(--color-main); color: white'>Toggle Popup Panel</button>";
//
//}
//add_action( 'wp_head', 'display_popup_panel', 0 );


?>

    <!--    <script type="text/javascript">-->
    <!--        window.onload = function () {-->
    <!--            var devButton = document.getElementById('popup-button');-->
    <!--            devButton.onclick = function () {-->
    <!--                var devPanel = document.getElementById('popup-panel');-->
    <!--                if(devPanel.style.display == "none") {-->
    <!--                    devPanel.style.display = "block";-->
    <!--                } else {-->
    <!--                    devPanel.style.display = "none";-->
    <!--                }-->
    <!--            }-->
    <!--        }-->
    <!--    </script>-->

<?php

