<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Address
 *
 * @property string $id
 * @property string $civility
 * @property string $name
 * @property string|null $country
 * @property string|null $city
 * @property string|null $line1
 * @property string|null $line2
 * @property string|null $postal_code
 * @property string|null $state
 * @property int $personnal
 * @property string $customer_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Category $customer
 * @method static \Database\Factories\AddressFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Address newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Address newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Address query()
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereCivility($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereLine1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereLine2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address wherePersonnal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereUpdatedAt($value)
 */
	class Address extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Category
 *
 * @property string $id
 * @property string $name
 * @property string $slug
 * @property string|null $img
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Product> $products
 * @property-read int|null $products_count
 * @method static \Database\Factories\CategoryFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereUpdatedAt($value)
 */
	class Category extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Customer
 *
 * @property string $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property mixed|null $meta
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Address> $addresses
 * @property-read int|null $addresses_count
 * @method static \Database\Factories\CustomerFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Customer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer query()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereMeta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereUpdatedAt($value)
 */
	class Customer extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Order
 *
 * @property string $id
 * @property string $reference
 * @property float $total
 * @property float $subtotal
 * @property string $tax
 * @property \App\Models\Address $shipping
 * @property string|null $facture
 * @property string $status
 * @property string $billing_id
 * @property string $shipping_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Address $billing
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OrderDetail> $order_details
 * @property-read int|null $order_details_count
 * @property-read \App\Models\OrderPayment|null $order_payment
 * @method static \Database\Factories\OrderFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order query()
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereBillingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereFacture($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereShipping($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereShippingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereSubtotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUpdatedAt($value)
 */
	class Order extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\OrderDetail
 *
 * @property string $id
 * @property string $name
 * @property float $price
 * @property float $qty
 * @property float $total
 * @property string|null $product_id
 * @property string $order_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Order $order
 * @property-read \App\Models\Product|null $product
 * @method static \Database\Factories\OrderDetailFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDetail whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDetail whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDetail wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDetail whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDetail whereQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDetail whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDetail whereUpdatedAt($value)
 */
	class OrderDetail extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\OrderPayment
 *
 * @property string $id
 * @property string $reference
 * @property string $status
 * @property string $channel
 * @property string|null $channel_detail
 * @property string|null $description
 * @property string|null $payment_url
 * @property mixed|null $error
 * @property mixed|null $meta
 * @property string $order_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Order $order
 * @method static \Database\Factories\OrderPaymentFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPayment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPayment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPayment query()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPayment whereChannel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPayment whereChannelDetail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPayment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPayment whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPayment whereError($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPayment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPayment whereMeta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPayment whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPayment wherePaymentUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPayment whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPayment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPayment whereUpdatedAt($value)
 */
	class OrderPayment extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Product
 *
 * @property string $id
 * @property string $name
 * @property string $slug
 * @property string|null $sku
 * @property string|null $short_description
 * @property string|null $description
 * @property float|null $price
 * @property string $stock
 * @property string $status
 * @property string|null $date_to_publish
 * @property int $qty
 * @property string $img
 * @property string $category_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Category $category
 * @method static \Database\Factories\ProductFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDateToPublish($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereShortDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSku($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUpdatedAt($value)
 */
	class Product extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Transfer
 *
 * @property string $id
 * @property string $currency
 * @property float $amount
 * @property string $reference
 * @property string|null $transaction_id
 * @property string $channel
 * @property string|null $channel_detail
 * @property string|null $beneficiary
 * @property string|null $description
 * @property string|null $payment_url
 * @property string|null $status
 * @property mixed|null $error
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\TransferFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Transfer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transfer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transfer query()
 * @method static \Illuminate\Database\Eloquent\Builder|Transfer whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transfer whereBeneficiary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transfer whereChannel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transfer whereChannelDetail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transfer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transfer whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transfer whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transfer whereError($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transfer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transfer wherePaymentUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transfer whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transfer whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transfer whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transfer whereUpdatedAt($value)
 */
	class Transfer extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property mixed $password
 * @property string|null $remember_token
 * @property string|null $timezone
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTimezone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

