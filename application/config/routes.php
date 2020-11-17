<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
// $route['default_controller'] = 'auth';
$route['default_controller'] = 'home_shop';
$route['404_override'] = 'error_404';
$route['translate_uri_dashes'] = false;

# Disable Controller access without routing
// $route['.*'] = "error404";

/* Routing Access
    https://stackoverflow.com/questions/2991323/how-to-hide-controller-name-in-the-url-in-codeigniter
    https://stackoverflow.com/questions/48061172/hiding-id-in-codeigniter-url
    https://stackoverflow.com/questions/35186185/hide-codeigniter-both-controller-and-method-name-from-url
    https://stackoverflow.com/questions/18630488/remove-or-hide-controller-name-from-url-in-codeigniter
    https://stackoverflow.com/questions/38828542/url-hide-using-codeigniter
*/

// Front's Page Route
$route['sign-in'] = 'Auth_shop';
$route['sign-in'] = 'Auth_shop/index';
$route['sign-up'] = 'Auth_shop/signup';
$route['forgot-password'] = 'Auth_shop/forgotPassword';
$route['sign-out'] = 'Auth_shop/logout';
$route['activate-account'] = 'Auth_shop/activate';
$route['reset-password'] = 'Auth_shop/resetPassword';

$route['get-data-category'] = 'Category_shop/getAllCategory';

$route['home'] = 'Home_shop';
$route['get-check-hot-products'] = 'Home_shop/getCheckHotProduct';
$route['set-hot-products'] = 'Home_shop/setHotProducts';
$route['get-hot-product-price'] = 'Home_shop/getHotProductPrice';
$route['get-hot-product-sale'] = 'Home_shop/getHotProductSale';

$route['product-section'] = 'Product_shop';
$route['product-section/(:any)'] = 'Product_shop/index';
$route['product-section/(:any)/(:any)'] = 'Product_shop/index/$1';

$route['product-section-category/(:any)'] = 'Product_shop/getAllProductCategory/$1';
$route['product-section-category/(:any)/(:any)'] = 'Product_shop/getAllProductCategory/$1/$1';

// Detail routes section 
$route['product-detail/(:any)'] = 'Product_shop/detailPageProduct/$1';
$route['set-detail-shopping-cart'] = 'Product_shop/setCartProductDetail';
$route['get-check-qty-product'] = 'Product_shop/getCheckQtyProductByID';
$route['get-available-stock-product'] = 'Product_shop/getAvailableStockProductByID';
$route['get-available-stock-variant-product'] = 'Product_shop/getAvailableStockVariantProductByID';
$route['get-related-product'] = 'Product_shop/getRelatedProduct';
$route['get-load-comment/(:any)'] = 'product_shop/getLoadAllComment/$1';
$route['get-comment-code'] = 'product_shop/createCommentCode';
$route['check-comment-customer'] = 'product_shop/checkCustomerComment';
$route['insert-comment-review'] = 'product_shop/insertCommentReview';
$route['insert-comment-image'] = 'product_shop/insertResizeImages';
$route['edit-comment-review/(:any)'] = 'customer_review/editCommentReview/$1';
$route['get-detail-comment-review'] = 'customer_review/getCommentDetailReviewByID';
$route['update-comment-review'] = 'customer_review/updateCommentReview';
$route['delete-comment-detail-review'] = 'customer_review/deleteCommentDetailReview';
$route['remove-comment-image'] = 'product_shop/removeImage';
$route['delete-comment-review/(:any)'] = 'product_shop/deleteCommentReview/$1';

$route['get-wishlist'] = 'Customer_profile/getWishlist';
$route['get-wishlist/(:any)'] = 'Customer_profile/getWishlist/$1';
$route['get-wishlist/(:any)/(:any)'] = 'Customer_profile/getWishlist/index/$1';

$route['set-wishlist/(:any)'] = 'Product_shop/setWishlist/$1';
$route['set-wishlist-customer/(:any)'] = 'Customer_profile/setWishlist/$1';
$route['set-wishlist-home/(:any)'] = 'Home_shop/setWishlist/$1';
$route['set-shopping-wishlist'] = 'Product_shop/setShoppingWishlist';
$route['get-product-category/(:any)'] = 'Category_shop/getAllProductCategory/$1';


$route['profile'] = 'Customer_profile';
$route['profile/(:any)'] = 'Customer_profile/index';
$route['address'] = 'Customer_profile/addressList';
// $route['address/(:any)'] = 'Customer_profile/addressList/$1';
$route['get-province-data'] = 'Customer_profile/getProvinceData';
$route['get-regency-data'] = 'Customer_profile/getRegencyData';
$route['get-district-data'] = 'Customer_profile/getDistrictData';
$route['get-subdistrict-data'] = 'Customer_profile/getSubDistrictData';
$route['get-address-data'] = 'Customer_profile/getFullAdressCustomer';
$route['update-address-data'] = 'Customer_profile/updateAddress';
$route['change-password'] = 'Customer_profile/changePassword';

$route['customer-review'] = 'Customer_review';
$route['customer-review/(:any)'] = 'Customer_review/index';
$route['get-data-customer-review'] = 'Customer_review/showDataReview';

$route['set-shopping-cart/(:any)'] = 'Product_shop/setShoppingCart/$1';
$route['get-shopping-cart'] = 'Product_shop/getShoppingCart';
$route['delete-shopping-cart/(:any)'] = 'Product_shop/deleteShoppingCart/$1';


$route['shopping-cart'] = 'Customer_cart';
$route['get-detail-shopping-cart'] = 'Customer_cart/getDetailShoppingCart';
$route['update-cart'] = 'Product_shop/updateDetailShoppingCart';


$route['check-out'] = 'Check_out';
$route['get-api-province'] = 'Check_out/getProvince'; // get data province from API RajaOngkir
$route['get-api-city'] = 'Check_out/getCityRegency'; // get data city from API RajaOngkir
$route['get-full-address'] = 'Check_out/getAddressDetailProvinceCity';
$route['get-company-full-address'] = 'Check_out/getCompanyAddressDetailProvinceCity';
$route['get-api-cost-shipment'] = 'Check_out/getCost'; // get data ongkir from API RajaOngkir
$route['get-check-out-billing'] = 'Check_out/getCheckOutBilling';
$route['get-check-out-order'] = 'Check_out/getCheckOutOrder';
$route['get-company-charge-val'] = 'Check_out/getCheckCompanyChargeValue';
$route['get-company-phone-number'] = 'Customer_purchase/getCompanyPhoneNumber';
$route['insert-check-out'] = 'Check_out/insertCheckOut';


$route['customer-history-purchase-order'] = 'Customer_purchase/index';
$route['customer-pay-report-page/(:any)'] = 'Customer_purchase/customerPayReport/$1';
$route['customer-pay-report-datetime'] = 'customer_purchase/getDatetimePayReport';
$route['customer-pay-report-customid'] = 'customer_purchase/getCustomIdPayReport';
$route['set-customer-pay-report'] = 'customer_purchase/setCustomerPayReport';
$route['get-data-customer-purchase'] = 'Customer_purchase/showPurchaseOrder';
$route['get-detail-customer-purchase/(:any)'] = 'Customer_purchase/detailPurchaseOrder/$1';
$route['print-customer-purchase/(:any)'] = 'Customer_purchase/printPurchaseOrder/$1';
$route['get-payment-due'] = 'Customer_reminder/getPaymentDue';
$route['get-reminder-cancel-from-payment-due'] = 'Customer_reminder/getReminderCancelFromPaymentDue';
$route['get-reminder-payment'] = 'Customer_reminder/getReminderPayment';


$route['customer-history-purchase-return'] = 'Customer_return/index';
$route['get-data-customer-return'] = 'Customer_return/showPurchaseReturn';
$route['get-detail-customer-return/(:any)'] = 'Customer_return/detailPurchaseReturn/$1';
$route['print-customer-return/(:any)'] = 'Customer_return/printPurchaseReturn/$1';
