=== Welcart e-Commerce ===
Contributors: Collne Inc., uscnanbu
Tags: Welcart, e-Commerce, shopping, cart, eShop, store, admin, calendar, manage, plugin, shortcode, widgets, membership
Requires at least: 5.5
Tested up to: 5.7
Requires PHP: 7.0 - 7.4
Stable tag: 2.2.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Welcart is a free e-commerce plugin for Wordpress with top market share in Japan.


== Description ==

Welcart is a free e-commerce plugin for Wordpress with top market share in Japan.
Welcart comes with many features and customizations for making an online store.
You can easily create your own original online store.


= SHOPPING CART SYSTEM =

You can sell any type of product (physical, digital, subscriptions).
There is no limit to the number of products, item photos, and categories.
You can manage items by SKU (Stock Keeping Unit) code.
Welcart has many options for pricing and shipping.
You can apply for up to 16 different payment options (Sony Payment, Paypal, Softbank Payment etc.) on Welcart's official website.
Please refer to the link below (Japanese version).

[Welcart Payment services(Japanese)](https://www.welcart.com/wc-settlement/)


= DESIGN =
Welcart has free standard templates and themes. 
You can customize the design and layout any way you like.
All themes are compliant to Wordpress standards.
Welcart provides a free responsive design theme (Welcart Basic), from the link below.

[Welcart Theme downloads(Japanese)](https://www.welcart.com/archives/category/item/itemgenre/template/)


= MANAGING SYSTEM =
Order data is automatically stored and updated in the database.
Welcart has a highly functional "order list" page, for viewing and updating orders.
You can narrow your search results by customer information, price, date, item type, etc.
You can also easily manage an order directly through its edit page, where you can edit order details, confirm the purchase, send confirmation emails, and much more.


= MEMBERSHIP SYSTEM =
Welcart has it's very own membership system, eliminating the need for any extra plugins.
Similar to the order list page, a highly functional member list page is also provided.
You can search for member data by customer information, purchase history, etc.
Member orders can be edited individually. 
You can also enable a point system for Welcart members.

[Welcart Community(Japanese)](http://www.welcart.com/wc-com/).


== Installation ==

= AUTOMATIC INSTALLATION =

In your WordPress admin panel, go to Plugins > New Plugin, search for Welcart e-Commerce for WordPress and click "Install now ".


= MANUAL INSTALLATION =

1. Alternatively, download the plugin and upload the entire usc-e-shop folder to the /wp-content/plugins/ directory.
2. Activate the plugin.


= ATTENTION =
 
In the process of activation of plugin, Welcart writes data on tables such as postmeta, options, and terms. When you install a blog existing already, to avoid unexpected damages or any other unexpected situation, backing up is strongly recommended.

Welcart is not responsible or does not have any guarantee for any kind of damage that you get by using or installing Welcart.
All the procedures must be done with self-responsibility of each user.


= RECOMMENDED ENVIRONMENT =

WordPress Ver.5.3 or greater
PHP 7.3
MySQL 5.5 or greater
Original domain and SSL (Shared SSL is not recommended)

Note: The server which PHP is working as safe mode is not supported.

Please refer to [Server Requirement (Japanese version)](https://www.welcart.com/wc-condition/)


== Frequently Asked Questions ==

Please see [Welcart Forum(Japanese)](https://www.welcart.com/community/forums).


== Screenshots ==

1. Item List page on the admin screen
2. Editing orders page on the admin screen
3. Top page(Free official theme 'Welcart Basic') 
4. Item page(Free official theme 'Welcart Basic') 


== Changelog ==
= V2.2.4 =
-----------
31 May 2021
* Fixed a vulnerability.

= V2.2.3 =
-----------
27 May 2021
* Added the template tag (function) for wc_templates.
* Fixed the bug that when using the "Welcart Recent Posts" widget, the titles of the posts are all set to the title of the currently displayed page.

= V2.2.2 =
-----------
19 May 2021
* [PayPal] Added explanation of "Pay-as-you-go" application to the credit card payment settings screen.
* [PayPal] Fixed the bug that the JavaScript error occurs in the confirmation page when you disable the PayPal payment.
* [PayPal] Fixed the bug that the payment failed when using the Multiple Shipping Plug-in.
* [SBPS] Added the explanation when you change the way of using API type to the credit card payment setting page.
* Changed the display of the basic setting "Member points: give/not give".
* Fixed the bug that the membership agreement description is displayed on the customer information page when the membership system is disabled.
* Fixed the bug that PHP Notice error appears during PDF output.
* Fixed the bug that hints for setting items in the administration page are not displayed when you click on the title.

= V2.2.1 =
-----------
19 Apr 2021
* Fixed the bug that brute force protection option settings failed to be updated.
* Fixed the bug that login error check is omitted in brute force protection.

= V2.2.0 =
-----------
12 Apr 2021
* Implemented new feature that enables the use of Google reCAPTCHA v3 for new member registrations to counter member spam.
* Improved the specification to strictly check and display the password policy at the time of member registration and password change.
* Implemented the function to deny access after consecutive login failures in order to counter brute force attacks on member logins.
* Improved the specification to enable unsorting when sorting by product code or product name in the product list on the administration page.
* Fixed the bug that prevented the conversions in the latest Google Analytics for WordPress by MonsterInsights.
* Fixed the bug that the search condition is canceled when moving to the second page of the product list when specifying the stock status.
* [PayPal] Fixed the bug that prevented re-payment after a payment error in the automatic order for subscription orders.
* [PayPal] Fixed the bug that the transaction amount on the recurring billing member information screen is not formatted in the currency.

= V2.1.8 =
-----------
29 Mar 2021
* [WelcartPay] Fixed the bug that points are not added at the time of postpaid payment (ATODENE).
* [PayPal] Fixed the bug that the mini-browser for payment is not displayed.
* [SBPS] Changed the specification to allow setting the number of days for the payment deadline for convenience store payments.
* [SBPS] Fixed the bug that name, email address and other information are not transferred to the payment screen of convenience store payment.
* [SBPS] Changed the specification to output the response to the payment error log.
* Support for displaying the total amount of consumption tax for business package discounts.
* Fixed the bug that the message of the unused payment module is displayed on the admin page when the subscription plugin "WCEX Auto Delivery" is activated.

= V2.1.7 =
-----------
22 Mar 2021
* [SBPS] Re-fix of V2.1.6

= V2.1.6 =
-----------
19 Mar 2021
* [SBPS] Fixed the bug that the payment information can not be updated from the Welcart management page.

= V2.1.5 =
-----------
12 Mar 2021
* Fixed the bug that WordPress health check shows "The loopback request to the site failed".
* [Metaps Payment] (Pay Design) Fixed the bug that the payment error occurs when the string of the product name is too long.
* [SBPS] Compatible with DLSeller and AutoDelivery.
* [SBPS] Fixed the bug that SESSION error occurred when using 3D Secure for linked payment.
* [SBPS] Basic authentication ID and Basic authentication Password can be entered in the link type.
* Added the function of attaching files to management e-mails from the order data edit page.
* Supported the total consumption tax display of the built-in template.
* Fixed the bug that the "Sales Tax" display in the purchase history is not correct when the sales tax category is switched.
* Fixed the bug that PHP Notice error appears in the member list when adding a custom member field.

= V2.1.4 =
-----------
2 Mar 2021
* Added the template tag for displaying the total amount of consumption tax.

= V2.1.3 =
-----------
22 Feb 2021
* [PayPal] Fixed the bug that DLSeller's auto-recurring billing emails are sent with zero entries.
* [PayPal] Implemented optimization of In-line guest purchase field.
* Fixed the bug that "Next Page" and "Previous Page" in the order data edit page are not displayed.
* Fixed the bug that clicking the "Start Search" button on the light-complex search result page redirects to the cart page.
* Fixed the bug that the message for wrong password in member login is not translated.
* Added an item for system environment information.
* Fixed the bug that the input field for the reduced tax rate is not hidden even if the standard tax rate is selected in the tax rate selection of the basic settings.
* Fixed the bug that the close icon of the dialog for credit card payment is not displayed.
* Changed the specification that "Limit points to total product value only" cannot be selected for point application when supporting reduced tax rate.

= V2.1.2 =
-----------
9 Feb 2021
* [PayPal, SB Payment] Fixed the bug that the sales transaction (sales posting, cancellation, etc.) cannot be processed in the order data edit page.

= V2.1.1 =
-----------
19 Jan 2021
* [WelcartPay] Fixed the bug that there is one extra CSV data item in the "Postpaid Payment Shipment Report Registration CSV Output" in Atodene's Postpaid Payment.
* [PayPal] Added a class to PayPal CP checkout form div.
* [PayPal] Fixed the bug that points are not added to the membership data when using PayPal CP for purchases if the timing of point adding is set to the time of deposit.
* [PayPal] Support locale for PayPal payment button.
* Fixed the bug that there are cases the page break of the delivery PDF doesn't work well when the setting is  "Reduced tax rate" .
* Changed the specification to not limit the scope of application of points when the setting is  "Reduced tax rate" .
* Changed the specification to check the existence of the product at the time of cart submission.
* Fixed the bug that an error displays when performing a batch operation on the Order List page.
* Fixed the bug that the ▼▲ of the "Mail Print Field Display" on the Order Data Edit page is reversed.
* Fixed the bug that the member No. is not reflected in the order data purchased without member registration even if the member information is imported or updated later.
* Fixed the bug that the purge number is all 1 under certain conditions in the delivery note, invoice, and receipt PFDs.
* Fixed the bug that "#NONE#" is selected when operating the smartphone if the product option is set to multi-select or required selection.
* Changed the specification to include an inventory check just before payment.

= V2.1.0 =
-----------
21 Dec 2020
* [PayPal] Implement PayPal Commerce Platform
* [ZEUS] Fixed the bug that causes a rare card payment error in ZEUS payments.
* Improved the error message description at login so that the existence of e-mail addresses is not guessed.
* Fixed the bug in version 2.0 that a 403 error causes after you see the order list and member list.
* Fixed the bug in version 2.0 that the zip code validation check doesn't work correctly when selecting a country outside of Japan.
* Fixed the bug in version 2.0 that a Warning error shows in the system environment.
* Fixed the bug in version 2.0 that  "Hide Operation Fields" is shown as the default in the old member list.
* Fixed the bug in version 2.0 that the filter function in the order list doesn't clear the previous search word.

= V2.0.1 =
-----------
10 Dec 2020
* Fixed the bug that cash on delivery fee was added when paying by credit card.

= V2.0.0 =
-----------
9 Dec 2020
* Resolved errors in WordPress Site Health Check.
* Compatible with jQery3 (WordPress 5.6).
* Compatible with PHP 7.4.
* Added the function of output the environmental information log.
* [WelcartPay] Fixed the bug that the next subscription order date in the email sent to the administrator is wrong when renewing a credit card in My Page.
* [ZEUS] Fixed the bug of a rare card payment error with ZEUS payment.
* [SBPS] Changed the specification that the first step of automatic sales in link type payment from "Automatic Sales" to "Credit" status.

= V1.9.37 =
-----------
24 Nov 2020
* [WelcartPay/e-SCOTT] Added the encryption key and other input fields in the payment setup page.
* Added a class to the DIV tag in the completion page after new member registration.
* Fixed the bug that the products with a unit price of 0 yen are not displayed on the PDF statement when the tax rate is reduced.
* Fixed the bug that the loading images are not displayed.
* Added the shipping company name "Yamato Transport".
* [SBPS] Fixed the bug that a PHP Warning error caused on the member data edit page when using linked type credit card payments.
* Compatible with Multiple Shipping fixes.
* Correct the translation.
* Fixed the bug that a JavaScript error caused when clicking the "Display Options" checkbox in the Order List page of the admin page.
* Fixed the bug that the "Sales Tax" label and amount are displayed incorrectly when the "Sales Tax Category" is changed during the process.

= V1.9.36 =
-----------
21 Oct 2020
* Fixed the vulnerability of PHP Object Injection.

= V1.9.35 =
-----------
19 Oct 2020
* [WelcartPay] Fixed the bug that the purchase completion page does not appear after successful payment with UnionPay.
* [WelcartPay] Fixed the bug that you can't re-authorize after canceling in the admin page.
* Fixed the bug that Notice error occurred when a product image isn't registered.

= V1.9.34 =
-----------
13 Oct 2020
* [SBPS] Added PayPay online payments.
* [SBPS] Added the function that users can cancel and make actual sales of the credit card payments in the admin page.
* [Zeus] Fixed the bug that the payment error happens when returning from 3D Secure authentication with certain conditions.
* [WelcartPay] Changed the specification to not use the session when recovering from three-way communication (external link type).
* [WelcartPay] Fixed the error in UnionPay payment.
* Fixed the unnecessary line feed code at the end of order list CSV.

= V1.9.33 =
-----------
15 Sep 2020
* Added the function to check for zip code validation.
* [PHP7.4 compatible] Fixed the bug that the error causes when generating PDF if certain characters (unknown) are used.
* [e-SCOTT] [WelcartPay] Fixed the bug that the settlement error causes in case of some 3D secure authentication.
* Avoided the inability to enable Welcart if the server is using old RC4-SHA encryption.
* Fixed the issue that Welcart doesn't work in WordPress.com in case of using WP5.5 or later.
* [WelcartPay] Fixed the bug that the deletion of payments doesn't work with WelcartPay's Atodene.

= V1.9.32 =
-----------
18 Aug 2020
* Fixed the bug that the checkboxes in the order list, member list and product list don't work on WP5.5.
* Fixed the bug that the member page transition doesn't work on WP5.5 environment.
* Fixed the bug that the error message appears when activating the plugin.
* Reviewing the delivery company name.

= V1.9.31 =
-----------
8 Jul 2020
* Exclude PHP 5.6 from the supported versions (no longer supported).
* Corrected the display of the number of stock per SKU in Control Panel > Item List.
* Fixed the bug that unnecessary columns are inserted in the download CSV data for "Order List Output", "Member Data Output", and "Order List Output" .
* Fixed the bug that some of the button styles on the admin screen are not working.
* [e-SCOTT] [WelcartPay] Fixed the bug that the display of the number of payments for installment payments is incorrect. 
* Fixed the bug that the error happens in checking for update of extension plugins and failing to activate Welcart.
* [WelcartPay] Added the function to return to session when SESSION EMPTY.
* Fixed the error in the getItemDiscount() function.

= V1.9.30 =
-----------
24 Apr 2020
* Added the function to display the update notification of the extended plugin.
* Added the option to show or hide the global message of the settlement errors.
* Fixed the bug that all menu titles in the member page are being the same titles of the member page when using a specific theme.
* Adjusted the style of the input field on the credit settlement settings page.
* Fixed the bug that the "Previous page" and "Next page" buttons on the order data edit page are not displayed.
* Fixed the bug that the custom customer field item isn't displayed in "Order List Output".
* Fixed the bug that the search result of "Order Search" is not reflected in "Order List Output".
* [WelcartPay] Fixed the bug that you can't change the "Next Billing Date" if you change it once.
* [Telecom] Fixed the bug that a duplicate order data is created.
* Added the function to specify the "duration" of the bestseller widget.

= V1.9.29 =
-----------
7 Apr 2020
* Improved the performance of a order list response. 
* Added a session recovery function for recover the session empty error of credit settlements.
* [e-SCOTT] [WelcartPay] Fixed the bug that Notice error occurs when there is no "TokenResponseCd".
* Compatible with WordPress 5.4
* [WelcartPay] Changed the specification that an item name is added in a result notification mail of an automatically-renewed time deposits.
* Added the function that a custom field specific input/output to an item CSV.
* Changed the specification that the IP address and useragent of a customer are displayed in a order data edit page.
* Fixed the bug that a data table isn't created on some hosting servers.
* Fixed the bug that you can't move to the next page in a cart page when the site isn't SSL  by supporting Chrome 80.
* Fixed the bug that a database error occurs when the session is time out in an item master page.
* Fixed the bug that the style of the calendar is broken in Welcart Default Theme.

= V1.9.28 =
-----------
9 Mar 2020
* Fixed the bug that you can't move to the next page in a cart page in some browser such as Egde by supporting Chrome 80.
* Fixed the bug that "Security check4" error occurs when you log in with login form in top page in Welcart Default Theme.

= V1.9.27 =
-----------
2 Mar 2020
* Fixed the bug that the item option in the past order list is disappear when you change the item option of the item master. 
* Fixed the bug that the calendar id tag of the calendar widget is not unique.
* Compatible with Chrome 80.
* Fixed the bug that the error occurs the member list in MySQL8.

= V1.9.26 =
-----------
30 Jan 2020
* [PayPal] Fixed the bug that "Pay Now" button doesn't work in the cart page.
* [WelcartPay] Fixed the bug of error in UnionPay Payment.
* [WelcartPay] Fixed the bug that a comma "," is attached to the amount in ATODENE's "Post-payment settlement transaction registration CSV".
* [WelcartPay] Changed the specification that limit available company names in ATODENE.
* [ZEUS] Changed the specification that a credit card can be registered in My Page when using QuickCharge and batch processing.
* Changed the specification that a member data can be shared with other Welcart.
* Changed the specification that "+" character can be used in the e-mail address check when sending.
* Fixed the bug that "sama" is inserted in the subject of the automatic reply mail when the language setting of the front page isn't Japanese and the administration page is English.
* Fixed the bug that a JavaScript error appears on the order edit screen in some environments.

= V1.9.25 =
-----------
18 Dec 2019
* Fixed the bug that in case of the mail authentication of "Next while registering a member", the site will be tranferred to the Welcart demo site  when you click  "Return to purchase".

= V1.9.24 =
-----------
16 Dec 2019
* [WelcartPay]Fixed the bug that you can purchase items even if the upper limit of payment is exceeded when using ATODENE.
* [WelcartPay]Added a feature of UnionPay Payment.
* [WelcartPay]Fixed the bug that yen mark is added to the consumption tax in "Postpaid payment transaction registration CSV when using ATODENE.
* Fixed translation of mail authentication function.
* Fixed the bug that menu titles such of footer and etc. are all "member login" on the member login page on the front page.
* Fixed the bug that the hyphen (-) cannot be used for custom member field keys.

= V1.9.23 =
-----------
5 Dec 2019
* Compatible with PHP7.3.
* Added a feature of a mail authentication.
* Fixed the bug that the tax-inclusive price becomes incorrect when updating the order data edit screen when using the reduced tax rate.
* [e-SCOTT][WelcartPay]Changed the specification that recording "3D secure authentication result code" in 3D secure.
* [e-SCOTT][WelcartPay]Corrected some error message translation.
* [WelcartPay]Fixed the bug that [Recording sales] is displayed again when [Change usage amount] after [Recording sales] in the settlement dialog.
* [WelcartPay]Fixed the bug that a CSV output button related ATODENE does't work in the order list.
* [e-SCOTT][WelcartPay]Changed the specification that 3D secure encryption key / initialization vector input is not required.
* [WelcartPay]Changed the specification that adding a history data even when a member error occurs in automatically-renewed time deposits.
* [e-SCOTT][WelcartPay]Fixed th bug that the card number input form doesn't appear in the dialog when there is index.html in Route.
* [e-SCOTT]Fixed th bug that a payment notification for convenience store payment cannot be received when using only convenience store.
* Changed the specification to add  "Manager Memo" item to "Order List" and "Order Details List" output CSV.
* Fixed the bug that an error isn't displayed even if you purchase more than the purchase limit if you set "Do not limit purchase when sold out" in item data editing page.
* Add "CLICKPOST" to shipping company name.
* Fixed the bug that "Discount" becomes 0 when "Apply tax rate after changing" is checked with [Recalculate] button in order data editing.
* Fixed the bug that the product is deleted immediately without alert confirmation when deleting the product on the product edit screen.
* Changed the specification to make it easy to set required address etc.
* Fixed the bug that the page in PDF output breaks unnecessarily when using "Reduced tax rate".
* Fixed the bug that Notice appears when logging out when using DLSeller.
* Fixed the bug that PHP7 Warning error occurs in tracking tag output in the specific environments.

= V1.9.22 =
-----------
20 Sep 2019
* Fixed the bug that the price of incluging tax is calculated by standard tax rate when the settings are "Reduced tax rate" and the item is included tax.
* Fixed the bug that the price which should be discount doesn't discount when the setting is "Reduced tax rate".
* Fixed the bug that the tax price doesn't display when "Consumption tax classification" and "Consumption tax subject" hasn't saved in past order data.
* Fixed the bug that "Shipping date" can't be searched by "more than" and "less than" in OrderList>OrderSearch.
* [WelcartPay] Changed the specification. "Settlement price" is being displayed in the settlement history of subscription settlement member information.
* Changed the specification. The date of Receipt PDF is delivery date(updated date).

= V1.9.21 =
-----------
29 Aug 2019
* Modified the function of Reduced tax rate.
* Added the SKU item mode on item CSV of an item batch registration and an item data output.
* [WelcartPay] Compatible with 3D Secure.
* [e-SCOTT Smart] Compatible with 3D Secure.
* [SBPS] Fixed the bug that the display of option changes to an  incorrect value on wallet settlement. 
* Fixed the bug that the style of the order completion page is skewed when not using 'wc_templates'.
* [Paygent] Fixed the bug that the payment method isn't registered on basic settings>payment method>payment method when the settings of the payment is completed.
* Changed the specification. You can't select the payment method when the settings of the credit payment is wrong.
* Changed the specification. The payment method being stopped when the settings of the credit payment changes to unused.
* Changed the specification. The product subtotal is added on the list of the order list output.

= V1.9.20 =
-----------
25 Jun 2019
* [PayPal EC]Added the feature of a bank settlement.
* Added the filter hook for the item CSV.

= V1.9.19 =
-----------
22 May 2019
* Added the feature of Reduced tax rate.
* Added the filter hook for customization of "Desired delivery date".
* [SBPS] Modified words, etc.
* Fixed the bug that you can't update custom order field and custom customer field.
* Fixed the bug that there are cases when payment_id isn't displayed in payment information.
* Fixed the bug that Datepicker in "Desired delivery date" and "Shipping date" doesn't work on new order estimation registration page.

= V1.9.18 =
-----------
22 Apr 2019
* [ZEUS]Fixed the bug that the credit card can't update in My Page in case of using ie11 or iPhone Safari.
* Changed the specification of the hook that the value status of "Check out" button in confirm page is changeable.
* Added the hook to get_member_history(). 
* Fixed the bug that an error occurs when specifying non-charactor in the second argument in is_status().
* Changed the specification that textarea available in custom order field.
* [Veritrans]Added the hook to the timing of receiving payment notification.
* Added the function that displaying additional information of payment method to the payment method name of administration email.
* Added the hook of judgement of deleting member information for front page.
* Fixed the bug that can't be registered as an error occurs if there are multiple shipping method in item batch registration.

= V1.9.17 =
-----------
5 Mar 2019
* [SBPaymentService]Compatible with Token settlement.
* [ZEUS][WelcartPay]Changed the specification that sending email to administrators when the information of credit card is changed on customer's my page.
* [e-SCOTT][WelcartPay]Changed the specification that administrators can delete the mismatched data of quick payment member on member editing page.
* Changed the specification that the display date isn't limited about "Desired delivery date" and "Shipping date".
* Fixed the bug that displaying "Security check2" in case without wc_templetes when click the button of "Next with membership for register". (Re-fixed)
* Added the hook of the judgement of deleting member information for the front page.
* Added the hook at the status response of the purchase history on the member data edit. (Re-fixed)

= V1.9.16 =
-----------
13 Feb 2019
* [PayPal EC]Fixed the bug that total amount process isn't match  when the currency is dollar.
* Fixed the bug that displaying "Security check4" when reload the page after login to my page.
* Fixed the bug that displaying "Security check2" in case without wc_templetes when click the button of "Next with membership for register".
* Fixed the bug that the item registration number of Welcart Shop Home doesn't decrease when the item delete(into the trash box). 
* Fixed the bug that displaying "Notice" on custom order field check.
* Changed the specification that the bank account for money transfer doesn't display in case of the payment method is post-payment. 
* Added Serbia to the sales country. 
* Added the hook at the status response of the purchase history on the member data edit.

= V1.9.15 =
-----------
15 Jan 2019
* Fixed the bug that the customfield can't registered when new registration by item CSV.
* Fixed the bug that you can't registrate item batch registration using slug name of category.
* Fixed the bug that the serialized customfield become broken when new or update registration by item CSV.
* [SBPS]Changed trade name of SB Payment Sevice.
* [WelcartPay]Fixed the bug that you can't record the sales after doing re-authorization.
* [WelcartPay]The email address which is automatically sending when the transaction of the automatically-renewed payments happens was changed to the member data's email address.
* Fixed the bug that some total amount displays isn't correct  when the currency is USD.
* Fixed the bug that the number of campaign discount calculation is round to the integer in case of the currency which needs to display after the decimal number.
* Changed the specification that the complettion notice become easy to find out on my page when users updated their information.
* Enhanced security of the member log-in.
* Added the hook at $usces->get_post_user_custom().
* Added the argument at $usces->get_post_user_custom().
* Added the hook at usces_action_reg_orderdata_stocks($args).

= V1.9.14 =
-----------
1 Nov 2018
* [Welcart]Compatible with PHP7.2.
* Changed the specification that it doesn't set MyIsam to the data table as the initial engine.
* Improved the taking time to be short when uploading item batch upload, and fixed some errors.
* Fixed the bug that disappearing half-width "+" in the mails sending from admin pages.
* [PayPal EC]Changed the words which are automatically inserted when you select PayPal EC in payment method.

= V1.9.13 =
-----------
3 Sep 2018
* [e-SCOTT][WelcartPay]Changed the specification that it doesn't allow to register "e-SCOTT" and "WelcartPay" at once to "available credit payment module".

= V1.9.12 =
-----------
31 Aug 2018
* Changed the specification that the processing doesn't stop when there are no authority of writing the log file on an article batch registration.
* Fix the bug that the character "&" is automatically changed "&amp;" in the sender name of mail.
* [e-SCOTT][WelcartPay]Fix the bug that the inside display of dialog window of Token settlement is none.
* Fix the bug of notice message appearing when the first activation of welcart.
* [e-SCOTT][WelcartPay]Changed the specification that it doesn't allow to register "e-SCOTT" and "WelcartPay" at once to "available credit payment module".
* Added Kazakhstan to the sales country.
* Fixed the bug that the discount amount is automatically changed to 0 when the recalculating button is clicked on the order data editing page.
* [REMISE Payment]Added the function that changing a credit card is available on "My Page".
* [PayPal EC]Fixed the bug of JavaScript error on cart page without login.
* [WelcartPay]Changed the specification that the maximum amount for fee(fixed) of online settlement can be setting.
* [WelcartPay]Fixed the bug of error on online settlement processing.
* [e-SCOTT][WelcartPay]Changed the specification that the processing category is mandatory.
* [e-SCOTT][WelcartPay]Added the option of using quick payment at every time.
* [ZEUS Paymen]Fixed the bug that the payment module except ZEUS is unavailabe on basic settings>payment method>payment method.
* [Paygent Payment]Fixed the bug that the order data of welcart is automatically generated when changing the settlement amount at Paygent admin page.

= V1.9.11 =
-----------
29 Jun 2018
* [Mizuho factor]changed the connection destination URL of test environment.
* Fix the bug that there are cases when e-commerce tracking is not recognized(sent) correctly. 
* [e-SCOTT][WelcartPay]Changed a display of the number of payment  to a blank in case of "lump sum payment only".
* Fixed the bug that site title on a statement of delivery PDF is garbled.
* Added the hook to "company" in a statement of delivery PDF.
* [e-SCOTT][WelcartPay]Changed the field of Token settlement authentication code to mandatory.
* Added the function of welcart membership password authorization. Specifing salt is available and etc.
* [ZEUS Payment]Fixed the bug that the status doesn't change to paid when the notice is reached on convenience payment.
* [Another Lane Payment]Changed the settlement URL.
* [WelcartPay]Fixed the bug that the registration of card member deosn't work in case of purchasing a subscription item at first time on external link type.
* [WelcartPay]Added the action hook to "Close" on payment information dialog.
* Fixed the bug that paging doesn't work on an old order list.
* [RobotPayment(CloudPayment)]Fixed the bug of payment error when using points over a total item price.
* [Yahoo wallet]Fixed the bug of payment error.
* Fix the bug of a decimal calculate of Javascript on order editing page.

= V1.9.10 =
-----------
5 Mar 2018
* Changed the timing of session_start.  It runs before any other plug-ins.
* Changed the design of nounce.  The different value sets to nounce on each session when it is important for security on front page.
* Added httpOnly attribute to session cookie. If AOSSL, added secure attribute.
* Strengthen the sanitizations.

= V1.9.9 =
-----------
2 Feb 2018
* [ZEUS Payment]Fixed bug that is not registered in Quick Charge when using Quick Charge with SecureLink.
* Added the option that is not restrict purchase (not check the stock) even when sold out.
* Added the function of chage the display name of stock status.
* Changed the label of "Use SSL" to "Switching SSL".

= V1.9.8 =
-----------
22 Jan 2018
* [ZEUS Payment]Compatible with Token settlement.
* Changed the timing of session_start.  It runs at welcart construct.
* Fixed the bug in case of the payment status is unexpected value when edit the order data.
* [Paydesign]Fixed the statements of content-type on the function of header.
* [e-SCOTT][WelcartPay] Changed the style of entering credit card number daialog on smart phone.
* [e-SCOTT][WelcartPay] Changed the display of payment information on order edit screen. The last 4 digits of credit card number and the expiration date aren't displayed.
* [WelcartPay] Changed the year-selection of the next contract renewal date to be able to choose until 10 years later on the auto-renewable subscriptions member information.

= V1.9.7 =
-----------
25 Dec 2017
* Fixed the bug of the error of "uscesCart" jQuery.
* [Paygent]Added "Supplementary display classification" on the sending parameter.
* Fixed the bug that the lack of end tag (</div>)  on order editing page.
* [e-SCOTT][WelcartPay]Modified the display position of the card information entering dialog.
* Added the destination name on "Ganbare Tencho!"csv output.
* Modified every PDF output. "ZIP mark" and "TEL" don't display when the address and TEL aren't filled in.
* Added the class fo style of customer information field on confirmation page.
* Added the correspondence status on purchase history of member information editing page on admin screen.
* [WelcartPay]Fixed the bug that the layout of order list is off when using postpay settlement.
* [WelcartPay]Fixed the bug of the error caused by old settlement information.
* [PayDesign]Fixed the bug of the error in case of the item name is long when credit cart payment.
* [e-SCOTT][WelcartPay]Fixed the bug that Token settlement dialogue doesn't display depending on the situation.

= V1.9.6 =
-----------
3 Nov 2017
* Compatible with WordPress4.8.3 design change of sanitizing. Fixed the bug of order list csv.
* [WelcartPay]Fixed the bug that members can't cntrol of payment on admin page when purchasing with changing the card number.

= V1.9.5 =
-----------
30 Oct 2017
* [WelcartPay]Compatible with Token settlement.
* [e-SCOTT]Compatible with Token settlement.
* Fixed the bug that "usces_noreceipt_status" hook doesn't work.
* Fixed the bug of unreflecting the change of "administartor memo" when registering new order estimate.
* Added the filter hook at "Total price" of PDF output.
* Added the filter hook for editing the remarks of order data csv.
* Fixed the untransrated error message at registering menber.
* Added the filter hook of changing font size of our company information on delivety note PDF.
* Changed the style of right justified on member list.

= V1.9.4 =
-----------
12 Sep 2017
* Fixed an object injection vulnerability
  We discovered a dangerous Object Injection vulnerability in front page.
  Please upgrade Ver.1.9.4 immediately. All the past versions are the target.
  Technical countermeasure details are here the link.
  https://plugins.trac.wordpress.org/changeset?sfp_email=&sfph_mail=&reponame=&new=1728429%40usc-e-shop&old=1728428%40usc-e-shop&sfp_email=&sfph_mail=
* Changed the print of the first page footer information on delivery note PDF doesn't show in case of multiple pages.
* Added [UnionPay] option in the payment module of Softbank Payment.
* Changed to no- public category is displayed on the selection on item lists in case of the search item category.
* Changed the consumption tax is included when the payment is points only.
* Fixed the bug of delivery date settings.
* Fixed the duplicate id value of "mailadress1" on "wc_customer_page.php".
* Fixed the lack information of order data in case of PayPal webpayment plus.
* Fixed the bug of point form.
* Corresponded the specifications change of "Yahoo! wallet".

= V1.9.3 =
-----------
5 Jul 2017
* Fixed the bug of duplicated payments on specific servers. [WelcartPay][e-SCOTT Smart]
* Fixed the bug of error message on[e-SCOTT Smart].
* Changed the specification of [WelcartPay].
* Fixed the bug of the item name length of [Pay design].
* Fixed the bug of PayPal settings caused by API expired.
* Fixed the bug of the link display on the member page of [ZEUS].
* Fixed the bug of calculating the price in case of using points.
* Changed JAVA scripts alert on confirmation page to decrease abandonment.

= V1.9.2 =
-----------
28 Apr 2017
* Added the feature of post payment "ATODENE" on [WelcartPay].
* Fixed the bug of calculating the price in case of BankCheck payment on [CloudPayment].
* Fixed the bug of installment payment number on e-mail. [WelcartPay].
* Fixed the bug of the item list page on admin page.
* Corresponded the version upgrade of WCEX DLSeller 3.0.
* Fixed the bug of credit card information display on [WelcartPay].
* Changed to make the failure log of auto-renewable subscriptions on [WelcartPay].
* Fixed the bug of filtering by delivery method on order list.
* Fixed the bug of payment error in case of using coupons on [WelcartPay][SONY Payment].
* Fixed the bug of notice message on admin and order data editing page.
* Fixed the bug of the data getting of receiving agency of online transaction on [WelcartPay].
* Fixed the bug of the link display on my page of [WelcartPay].
* Added the feature of updating the data only "the stock amount" or "the stock status" on item batch registration and item data export.
* Fixed the country code of Sweden.

= V1.9.1 =
-----------
26 Dec 2016
* Added the feature of CSV export that items have multiple custom field and same key.
* Changed the specification of [E-SCOTT] and [WelcartPay] to disable to delete account on My Page.
* Fixed the calculate system of point.
* Added SKU code to item code of item number on [PayPal EC].
* Added the function of item batch registration and item data export to resister/export the category by slug.
* Fixed the bug of point adding on order editing page.
* Fixed the bug of registration member information on front page.
* Fixed the bug of the error in comment meta box on item master.
* Fixed the bug of updating member data.
* Fixed the bug of the base country data getting in payment method page.
* Fixed the bug of the advance value disappearing in case of updating sku information when using WCEX_SKU_SELECT + advance field.
* Added the feature of countermeasure for protect the member registration spam.
* Fixed the bug of character automatically changing from [+] to [ ] on some prints and e-mails.
* Fixed the bug of the totals print on invoice PDF.
* Fixed the bug of the error when the agencies unavailable on credit payment selecting page.
* Changed the color of "Credit sales accounting" on [WelcartPay].
* Fixed the bug of sorting on delivery /payment page.
* Fixed the bug of exporting payment error log.
* Fixed the bug of displaying the status of deposit confirmation on order editing page.

= V1.9 =
-----------
5 Oct 2016
* Added the new payment module "WelcartPay"
* Fixed the bug that the sub-image is not recognized


== Upgrade Notice ==

= 1.9.4 =
This version fixes an object injection vulnerability. Upgrade immediately.

