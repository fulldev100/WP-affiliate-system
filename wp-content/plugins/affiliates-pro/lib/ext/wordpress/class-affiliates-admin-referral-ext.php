<?php
/**
 * class-affiliates-admin-referral-ext.php
 *
 * Copyright (c) 2017 "kento" Karim Rahimpur www.itthinx.com
 *
 * This code is released under the GNU General Public License.
 * See COPYRIGHT.txt and LICENSE.txt.
 *
 * This code is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * This header and all notices must be kept intact.
 *
 * @author Karim Rahimpur
 * @package affiliates-pro
 * @since affiliates-pro 3.0.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Extends the referral editing form.
 */
class Affiliates_Admin_Referral_Ext {

	public static function init() { add_filter( 'affiliates_admin_referrals_expanded_items', array( __CLASS__, 'affiliates_admin_referrals_expanded_items' ), 10, 2 ); add_filter( 'affiliates_admin_referral_edit_add_referral', array( __CLASS__, 'affiliates_admin_referral_edit_add_referral' ), 10, 2 ); add_filter( 'affiliates_admin_referral_edit_update_referral', array( __CLASS__, 'affiliates_admin_referral_edit_update_referral' ), 10, 2 ); add_filter( 'affiliates_admin_referral_edit_form_suffix', array( __CLASS__, 'affiliates_admin_referral_edit_form_suffix' ), 10, 2 ); add_action( 'affiliates_deleted_referral', array( __CLASS__, 'affiliates_deleted_referral' ), 10, 1 ); }

	public static function affiliates_admin_referrals_expanded_items( $output, $params ) { $IX77734 = isset( $params['referral_id'] ) ? $params['referral_id'] : null; $IX71142 = isset( $params['expanded_items'] ) ? $params['expanded_items'] : null; $IX93439 = isset( $params['column_count'] ) ? $params['column_count'] : null; $IX16510 = isset( $params['i'] ) ? $params['i'] : null; if ( $IX71142 ) { $IX62325 = ''; $IX69314 = AFFILIATES_EXPANDER_RETRACT; } else { $IX62325 = ' style="display:none;" '; $IX69314 = AFFILIATES_EXPANDER_EXPAND; } $IX78865 = new Affiliates_Referral_WordPress(); if ( $IX78865->read( $IX77734 ) ) { $IX15508 = $IX78865->referral_items; if ( $IX15508 ) { $output .= '<tr class="items ' . ( $IX16510 % 2 == 0 ? 'even' : 'odd' ) . '">'; $output .= "<td colspan='$IX93439'>"; $output .= '<div class="view-toggle">'; $output .= "<div class='expander'>$IX69314</div>"; $output .= '<div class="view-toggle-label">' . __( '項目', 'affiliates' ) . '</div>'; $output .= "<div class='view' $IX62325>"; $output .= '<table class="referral-items wp-list-table widefat fixed" cellspacing="0">'; $output .= '<thead>'; $output .= '<tr>'; $output .= '<th scope="col" class="referral_item_id">' . __( 'ID', 'affiliates' ) . '</th>'; $output .= '<th scope="col" class="reference">' . __( '參考', 'affiliates' ) . '</th>'; $output .= '<th scope="col" class="item_amount">' . __('行數', 'affiliates' ) . '</th>'; $output .= '<th scope="col" class="amount">' . __('數量', 'affiliates' ) . '</th>'; $output .= '<th scope="col" class="currency_id">' . __('貨幣', 'affiliates' ) . '</th>'; $output .= '<th scope="col" class="rate_id">' . __('速度', 'affiliates' ) . '</th>'; $output .= '</tr>'; $output .= '</thead>'; $output .= '<tbody>'; if ( is_array( $IX15508 ) ) { $IX50810 = new Affiliates_Rate(); foreach ( $IX15508 as $IX96834 ) { $output .= '<tr class="referral-item">'; $output .= '<td class="referral-item-id">'; $output .= intval( $IX96834->referral_item_id ); $output .= '</td>'; $output .= '<td class="referral-item-reference">'; $output .= stripslashes( wp_filter_nohtml_kses( $IX96834->reference ) ); $output .= '</td>'; $output .= '<td class="referral-item-line-amount">'; $output .= stripslashes( wp_filter_nohtml_kses( $IX96834->line_amount ) ); $output .= '</td>'; $output .= '<td class="referral-item-amount">'; $output .= stripslashes( wp_filter_nohtml_kses( $IX96834->amount ) ); $output .= '</td>'; $output .= '<td class="referral-item-currency">'; $output .= stripslashes( wp_filter_kses( $IX96834->currency_id ) ); $output .= '</td>'; $output .= '<td class="referral-item-rate_id">'; if ( $IX96834->rate_id ) { if ( $IX50810->read( $IX96834->rate_id ) ) { $IX67893 = $IX50810->value; if ( $IX50810->type === AFFILIATES_PRO_RATES_TYPE_FORMULA ) { $IX67893 = $IX50810->get_meta( 'formula' ); } $output .= sprintf( '#%d %s %s', intval( $IX50810->rate_id ), esc_html( $IX50810->type ), esc_html( $IX67893 ) ); } else { $output .= '#' . intval( $IX96834->rate_id ); } } $output .= '</td>'; $output .= '</tr>'; } } $output .= '</tbody>'; $output .= '</table>'; $output .= '</div>'; $output .= '</div>'; $output .= '</td>'; $output .= '</tr>'; } } return $output; }

	public static function affiliates_admin_referral_edit_add_referral( $add_referral, $params ) { $IX59316 = ''; $IX99891 = isset( $params['affiliate_id'] ) ? $params['affiliate_id'] : null; $IX48398 = isset( $params['datetime'] ) ? $params['datetime'] : null; $IX73157 = isset( $params['description'] ) ? $params['description'] : null; $IX86229 = isset( $params['reference_amount'] ) ? $params['reference_amount'] : null; $IX95825 = isset( $params['amount'] ) ? $params['amount'] : null; $IX53699 = isset( $params['currency_id'] ) ? $params['currency_id'] : null; $IX92007 = isset( $params['status'] ) ? $params['status'] : null; $IX69413 = isset( $params['reference'] ) ? $params['reference'] : null; $IX86613 = new Affiliates_Referral_WordPress(); $IX86613->affiliate_id = $IX99891; $IX86613->datetime = $IX48398; $IX86613->description = $IX73157; $IX86613->reference_amount = $IX86229; $IX86613->amount = $IX95825; $IX86613->currency_id = $IX53699; $IX86613->status = $IX92007; $IX86613->type = 'manual'; $IX86613->reference = $IX69413; $IX17131 = isset( $_POST['item_reference'] ) ? count( $_POST['item_reference'] ) : 0; $IX60886 = isset( $_POST['item_id'] ) ? $_POST['item_id'] : array(); $IX89583 = isset( $_POST['item_reference'] ) ? $_POST['item_reference'] : array(); $IX92434 = isset( $_POST['item_type'] ) ? $_POST['item_type'] : array(); $IX98179 = isset( $_POST['item_rate_id'] ) ? $_POST['item_rate_id'] : array(); $IX67561 = isset( $_POST['item_line_amount'] ) ? $_POST['item_line_amount'] : array(); $IX68300 = isset( $_POST['item_amount'] ) ? $_POST['item_amount'] : array(); $IX90177 = isset( $_POST['item_currency_id'] ) ? $_POST['item_currency_id'] : array(); $IX13329 = isset( $_POST['item_object_id'] ) ? $_POST['item_object_id'] : array(); $IX60886 = array_map( 'trim', $IX60886 ); $IX89583 = array_map( 'trim', $IX89583 ); $IX92434 = array_map( 'trim', $IX92434 ); $IX98179 = array_map( 'trim', $IX98179 ); $IX67561 = array_map( 'trim', $IX67561 ); $IX68300 = array_map( 'trim', $IX68300 ); $IX90177 = array_map( 'trim', $IX90177 ); $IX13329 = array_map( 'trim', $IX13329 ); $IX49804 = array(); for ( $IX15474=0; $IX15474 < $IX17131; $IX15474++ ) { $IX49804[] = new Affiliates_Referral_Item( array( 'reference' => $IX89583[$IX15474], 'type' => $IX92434[$IX15474], 'rate_id' => $IX98179[$IX15474], 'line_amount' => $IX67561[$IX15474], 'amount' => $IX68300[$IX15474], 'currency_id' => $IX53699, 'object_id' => $IX13329[$IX15474] ) ); } $IX86613->referral_items = $IX49804; $IX86613->create(); return array( 'add_referral' => false, 'output' => $IX59316, 'referral_id' => $IX86613->referral_id ); }

	public static function affiliates_admin_referral_edit_update_referral( $update_referral, $params ) { $IX67136 = ''; $IX64216 = isset( $params['referral_id'] ) ? $params['referral_id'] : null; $IX55367 = isset( $params['affiliate_id'] ) ? $params['affiliate_id'] : null; $IX77813 = isset( $params['datetime'] ) ? $params['datetime'] : null; $IX92837 = isset( $params['description'] ) ? $params['description'] : null; $IX32908 = isset( $params['reference_amount'] ) ? $params['reference_amount'] : null; $IX84509 = isset( $params['amount'] ) ? $params['amount'] : null; $IX55491 = isset( $params['currency_id'] ) ? $params['currency_id'] : null; $IX25644 = isset( $params['status'] ) ? $params['status'] : null; $IX76714 = isset( $params['reference'] ) ? $params['reference'] : null; try { $IX57762 = new Affiliates_Referral_WordPress(); $IX57762->read( $IX64216 ); $IX39074 = isset( $_POST['item_reference'] ) ? count( $_POST['item_reference'] ) : 0; $IX38030 = !empty( $_POST['item_id'] ) ? $_POST['item_id'] : array(); $IX47473 = !empty( $_POST['item_reference'] ) ? $_POST['item_reference'] : array(); $IX74497 = !empty( $_POST['item_type'] ) ? $_POST['item_type'] : array(); $IX28721 = !empty( $_POST['item_rate_id'] ) ? $_POST['item_rate_id'] : array(); $IX57401 = !empty( $_POST['item_line_amount'] ) ? $_POST['item_line_amount'] : array(); $IX20411 = !empty( $_POST['item_amount'] ) ? $_POST['item_amount'] : array(); $IX96198 = !empty( $_POST['item_currency_id'] ) ? $_POST['item_currency_id'] : array(); $IX70933 = !empty( $_POST['item_object_id'] ) ? $_POST['item_object_id'] : array(); $IX38030 = array_map( 'trim', $IX38030 ); $IX47473 = array_map( 'trim', $IX47473 ); $IX74497 = array_map( 'trim', $IX74497 ); $IX28721 = array_map( 'trim', $IX28721 ); $IX57401 = array_map( 'trim', $IX57401 ); $IX20411 = array_map( 'trim', $IX20411 ); $IX96198 = array_map( 'trim', $IX96198 ); $IX70933 = array_map( 'trim', $IX70933 ); $IX81986 = array(); for ( $IX30198=0; $IX30198 < $IX39074; $IX30198++ ) { $IX81986[] = new Affiliates_Referral_Item( array( 'referral_item_id' => !empty( $IX38030[$IX30198] ) ? intval( $IX38030[$IX30198] ) : null, 'reference' => !empty( $IX47473[$IX30198] ) ? $IX47473[$IX30198] : null, 'type' => !empty( $IX74497[$IX30198] ) ? $IX74497[$IX30198] : null, 'rate_id' => !empty( $IX28721[$IX30198] ) ? intval( $IX28721[$IX30198] ) : null, 'line_amount' => !empty( $IX57401[$IX30198] ) ? $IX57401[$IX30198] : null, 'amount' => !empty( $IX20411[$IX30198] ) ? $IX20411[$IX30198] : null, 'currency_id' => $IX55491, 'referral_id' => !empty( $IX64216 ) ? intval( $IX64216 ) : null, 'object_id' => !empty( $IX70933[$IX30198] ) ? intval( $IX70933[$IX30198] ) : null ) ); } $IX57762->referral_items = $IX81986; $IX57762->affiliate_id = intval( $IX55367 ); $IX57762->datetime = $IX77813; $IX57762->description = $IX92837; $IX57762->reference_amount = $IX32908; $IX57762->amount = $IX84509; $IX57762->currency_id = $IX55491; $IX57762->status = $IX25644; $IX57762->reference = $IX76714; if ( $IX57762->update( array( 'affiliate_id' => intval( $IX55367 ), 'datetime' => $IX77813, 'description' => $IX92837, 'reference_amount' => $IX32908, 'amount' => $IX84509, 'currency_id' => $IX55491, 'status' => $IX25644, 'reference' => $IX76714 ) ) ) { $IX67136 .= '<br/>'; $IX67136 .= '<div class="info">' . __( '推薦已保存。', 'affiliates' ) . '</div>'; $IX61905 = true; } } catch ( Exception $IX40915 ) { $IX67136 .= '<br/>'; $IX67136 .= '<div class="error">' . __( '無法保存推薦。', 'affiliates' ) . '</div>'; } $IX22444[] = $IX67136; return array( 'update_referral' => false, 'output' => $IX67136 ); }

	public static function affiliates_admin_referral_edit_form_suffix( $output, $params ) { $IX98498 = isset( $params['referral_id'] ) ? $params['referral_id'] : null; $IX40308 = isset( $params['affiliate_id'] ) ? $params['affiliate_id'] : null; $IX35586 = isset( $params['datetime'] ) ? $params['datetime'] : null; $IX59353 = isset( $params['description'] ) ? $params['description'] : null; $IX58136 = isset( $params['reference_amount'] ) ? $params['reference_amount'] : null; $IX69897 = isset( $params['amount'] ) ? $params['amount'] : null; $IX70142 = isset( $params['currency_id'] ) ? $params['currency_id'] : null; $IX10968 = isset( $params['status'] ) ? $params['status'] : null; $IX14601 = isset( $params['reference'] ) ? $params['reference'] : null; $IX61901 = new Affiliates_Referral_WordPress(); $IX61901->read( $IX98498 ); $output .= '<h2>'; $output .= __( '推薦項目', 'affiliates' ); $output .= '</h2>'; $output .= sprintf( '<span class="new-referral-item button" title="%s">', esc_attr( 'Add a new referral item to this referral.', 'affiliates' ) ); $output .= sprintf( '<img src="%s" alt="%s" class="img_add_item_action" style="vertical-align:middle;padding-bottom:2px;"/>', esc_url( AFFILIATES_PLUGIN_URL . 'images/add.png' ), esc_attr( __( '新推薦項目', 'affiliates' ) ) ); $output .= ' '; $output .= __( '新推薦項目', 'affiliates' ); $output .= '</span>'; $output .= '<br/><br/>'; $output .= '<table class="referral_items" id="referral_items">'; $output .= '<thead>'; $output .= '<th>'; $output .= __( 'ID', 'affiliates' ); $output .= '</th>'; $output .= '<th>'; $output .= __( '參考', 'affiliates' ); $output .= '</th>'; $output .= '<th>'; $output .= __('類型', 'affiliates' ); $output .= '</th>'; $output .= '<th>'; $output .= __('目的', 'affiliates' ); $output .= '</th>'; $output .= '<th>'; $output .= __('費率 ID', 'affiliates' ); $output .= '</th>'; $output .= '<th>'; $output .= __('行數', 'affiliates' ); $output .= '</th>'; $output .= '<th>'; $output .= __('數量', 'affiliates' ); $output .= '</th>'; $output .= '<th>'; $output .= __('貨幣', 'affiliates' ); $output .= '</th>'; $output .= '<th>'; $output .= ''; $output .= '</th>'; $output .= '</thead>'; $IX27203 = 0; $output .= '<tbody>'; $output .= '<script type="text/javascript">'; $output .= 'affiliates_plugin_url = \'' . AFFILIATES_PLUGIN_URL . '\';'; $output .= 'affiliates_referral_item_remove_alt = \'' . __('消除', 'affiliates' ) . '\';'; $output .= 'affiliates_referral_item_remove_title = \'' . __('從推薦中刪除此推薦項目。', 'affiliates' ) . '\';'; $output .= '</script>'; if ( ( $IX61901->referral_items ) && ( sizeof( $IX61901->referral_items ) > 0 ) ) { foreach ( $IX61901->referral_items as $IX45418 ) { $output .= sprintf( '<tr id="row_%s">', $IX27203 ); $output .= '<td>'; $output .= esc_html( $IX45418->referral_item_id ); $output .= sprintf( '<input type="hidden" name="item_id[]" value="%s"></input>', esc_attr( $IX45418->referral_item_id ) ); $output .= '</td>'; $output .= '<td>'; $output .= sprintf( '<input type="text" name="item_reference[]" value="%s"></input>', esc_attr( $IX45418->reference ) ); $output .= '</td>'; $output .= '<td>'; $output .= sprintf( '<input type="text" name="item_type[]" value="%s"></input>', esc_attr( $IX45418->type ) ); $output .= '</td>'; $output .= '<td>'; $output .= sprintf( '<input type="text" name="item_object_id[]" value="%s"></input>', esc_attr( $IX45418->object_id ) ); $output .= '</td>'; $output .= '<td>'; $output .= sprintf( '<input type="text" name="item_rate_id[]" value="%s"></input>', esc_attr( $IX45418->rate_id ) ); $output .= '</td>'; $output .= '<td>'; $output .= sprintf( '<input type="text" name="item_line_amount[]" value="%s"></input>', esc_attr( $IX45418->line_amount ) ); $output .= '</td>'; $output .= '<td>'; $output .= sprintf( '<input type="text" name="item_amount[]" value="%s"></input>', esc_attr( $IX45418->amount ) ); $output .= '</td>'; $output .= '<td>'; $output .= sprintf( '<input type="text" name="item_currency_id[]" value="%s" readonly="readonly"></input>', esc_attr( $IX45418->currency_id ) ); $output .= '</td>'; $output .= '<td class="actions">'; $output .= sprintf( '<img src="%s" alt="%s" class="img_remove_action" row_id="%d" title="%s"/>', esc_url( AFFILIATES_PLUGIN_URL . 'images/remove.png' ), esc_attr( __('消除', 'affiliates' ) ), esc_attr( $IX27203 ), esc_attr( __('從推薦中刪除此推薦項目。', 'affiliates' ) ) ); $output .= '</td>'; $output .= '</tr>'; $IX27203++; } } $output .= '</tbody>'; $output .= '</table>'; $output .= '<input type="hidden" name="num_items" id="num_items" value="' . $IX27203 . '"></input>'; $output .= '<br/><br/>'; return $output; }

	public static function affiliates_deleted_referral( $referral_id ) { global $affiliates_db; $IX70009 = $affiliates_db->get_tablename( 'referral_items' ); $IX86535 = $affiliates_db->get_objects( "SELECT * FROM $IX70009 WHERE referral_id = %d", intval( $referral_id ) ); if ( count( $IX86535 ) > 0 ) { foreach( $IX86535 as $IX56421 ) { if ( $affiliates_db->query( "DELETE FROM $IX70009 WHERE referral_item_id = %d", intval( $IX56421->referral_item_id ) ) ) { do_action( 'affiliates_deleted_referral_item', intval( $IX56421->referral_item_id ), $IX56421 ); } } } }
}
Affiliates_Admin_Referral_Ext::init();