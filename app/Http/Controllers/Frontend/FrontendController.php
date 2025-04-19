<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\ContactMail;
use App\Models\About;
use App\Models\AppDownload;
use App\Models\BannerSlider;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogComment;
use App\Models\Category;
use App\Models\ChefTeam;
use App\Models\contact;
use App\Models\Counter;
use App\Models\Coupon;
use App\Models\DailyOffer;
use App\Models\PrivacyPolicy;
use App\Models\Product;
use App\Models\ProductRating;
use App\Models\Reservation;
use App\Models\SectionTitles;
use App\Models\Slider;
use App\Models\Subscriber;
use App\Models\TermsAndCondition;
use App\Models\Testimonial;
use App\Models\WhyChooseUs;
use Auth;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class FrontendController extends Controller
{
    public function getSectionTitle(): Collection
    {
        $keys = [
            'why_choose_top_title',
            'why_choose_main_title',
            'why_choose_sub_title',
            'daily_offer_top_title',
            'daily_offer_main_title',
            'daily_offer_sub_title',
            'chef_team_top_title',
            'chef_team_main_title',
            'chef_team_sub_title',
            'testimonial_top_title',
            'testimonial_main_title',
            'testimonial_sub_title'
        ];

        return SectionTitles::whereIn('key', $keys)->get()->pluck('value', 'key');
    }

    public function index(): View
    {
        $sliders = Slider::where('status', 1)->get();

        $sectionTitles = $this->getSectionTitle();

        $why_choose = WhyChooseUs::where('status', 1)->get();

        $categories = Category::where(['show_at_home' => 1, 'status' => 1])->get();
        $offers = DailyOffer::with('product')->where('status', 1)->take(10)->get();
        $bannerSliders = BannerSlider::where('status', 1)->latest()->take(10)->get();
        $chefTeam = ChefTeam::where(['status' => 1, 'show_at_home' => 1])->get();
        $app = AppDownload::first();
        $testimonials = Testimonial::where(['show_at_home' => 1, 'status' => 1])->get();
        $counter = Counter::first();
        $latestBlogs = Blog::withCount(['comments' => function ($query) {
            $query->where('status', 1);
        }])->with(['category', 'user'])->where('status', 1)->latest()->take(3)->get();
        return view('frontend.home.home', compact(
            'sliders',
            'sectionTitles',
            'why_choose',
            'categories',
            'offers',
            'bannerSliders',
            'chefTeam',
            'app',
            'testimonials',
            'counter',
            'latestBlogs'
        ));
    }

    function chef()
    {
        $chefs = ChefTeam::where(['status' => 1])->paginate(8);
        return view('frontend.pages.chef', compact('chefs'));
    }

    function testimonial()
    {
        $testimonials = Testimonial::where(['status' => 1])->paginate(9);
        return view('frontend.pages.testimony', compact('testimonials'));
    }

    function aboutPage()
    {
        $keys = [
            'why_choose_top_title',
            'why_choose_main_title',
            'why_choose_sub_title',
            'chef_team_top_title',
            'chef_team_main_title',
            'chef_team_sub_title',
            'testimonial_top_title',
            'testimonial_main_title',
            'testimonial_sub_title'
        ];

        $about = About::first();
        $why_choose = WhyChooseUs::where('status', 1)->get();
        $chefTeam = ChefTeam::where(['status' => 1, 'show_at_home' => 1])->get();
        $counter = Counter::first();
        $testimonials = Testimonial::where(['show_at_home' => 1, 'status' => 1])->get();
        $sectionTitles = SectionTitles::whereIn('key', $keys)->get()->pluck('value', 'key');
        return view('frontend.pages.about', compact(
            'about',
            'why_choose',
            'sectionTitles',
            'chefTeam',
            'counter',
            'testimonials'
        ));
    }

    function privatePolicy()
    {
        $privatePolicy = PrivacyPolicy::first();
        return view('frontend.pages.privacy', compact('privatePolicy'));
    }

    function termsAndCons()
    {
        $termsAndCons = TermsAndCondition::first();
        return view('frontend.pages.terms&cons', compact('termsAndCons'));
    }

    function contact()
    {
        $contact = contact::first();
        return view('frontend.pages.contact', compact('contact'));
    }

    function sendContactMessage(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'subject' => ['required', 'max:255'],
            'message' => ['required', 'max:1000']
        ]);

        Mail::send(new ContactMail($request->name, $request->email, $request->subject, $request->message));
        return response(['status' => 'success', 'message' => 'Message Sent']);
    }

    function blogs(Request $request)
    {
        $blogs = Blog::withCount(['comments' => function ($query) {
            $query->where('status', 1);
        }])->with(['category', 'user'])->where(['status' => 1]);

        if ($request->has('search') && $request->filled('search')) {
            $blogs->where(function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('post', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('category') && $request->filled('category')) {
            $blogs->whereHas('category', function ($query) use ($request) {
                $query->where('slug', $request->category);
            });
        }

        $blogs = $blogs->latest()->paginate(9);
        $categories = BlogCategory::where('status', 1)->get();
        return view('frontend.pages.blog', compact('blogs', 'categories'));
    }

    function blogDetails(string $slug)
    {
        $blog = Blog::with(['user'])->where(['slug' => $slug, 'status' => 1])->firstOrFail();
        $comments = $blog->comments()->where('status', 1)->orderBy('id', 'DESC')->paginate(20);
        $latestBlogs = Blog::select('id', 'title', 'slug', 'image', 'created_at')->where('status', 1)
            ->where('id', '!=', $blog->id)->latest()->take(5)->get();
        $categories = BlogCategory::withCount(['blogs' => function ($query) {
            $query->where('status', 1);
        }])->where('status', 1)->get();
        $nextBlog = Blog::select('id', 'title', 'slug', 'image')->where('id', '>', $blog->id)->orderBy('id', 'ASC')->first();
        $previousBlog = Blog::select('id', 'title', 'slug', 'image')->where('id', '<', $blog->id)->orderBy('id', 'DESC')->first();

        return view('frontend.pages.blog-details', compact(
            'blog',
            'latestBlogs',
            'categories',
            'nextBlog',
            'previousBlog',
            'comments'
        ));
    }

    function blogCommentsStore(Request $request, $blog_id)
    {
        $request->validate([
            'comment' => ['required', 'max:255']
        ]);

        Blog::findOrFail($blog_id);

        $comment = new BlogComment();
        $comment->blog_id = $blog_id;
        $comment->user_id = auth()->user()->id;
        $comment->comment = $request->comment;
        $comment->save();

        toastr()->success('Comment Sent, pending approval');
        return redirect()->back();
    }

    function reservation(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:255'],
            'phone' => ['required', 'max:50'],
            'date' => ['required', 'date', 'max:50'],
            'date' => ['required'],
            'persons' => ['required', 'numeric'],
        ]);

        if (!Auth::check()) {
            throw ValidationException::withMessages(['Please login to make a reservation']);
        }
        $reservation = new Reservation();
        $reservation->reservation_id = rand(0, 500000);
        $reservation->user_id = auth()->user()->id;
        $reservation->name = $request->name;
        $reservation->phone = $request->phone;
        $reservation->date = $request->date;
        $reservation->time = $request->time;
        $reservation->persons = $request->persons;
        $reservation->status = 'pending';
        $reservation->save();

        return response(['status' => 'success', 'message' => 'Reservation Booked']);
    }

    function subscribeNewsletter(Request $request)
    {
        $request->validate(
            [
                'email' => ['required', 'email', 'max:255', 'unique:subscribers,email']
            ],
            [
                'email.unique' => 'Email has already subscribed!'
            ]
        );

        $subscriber = new Subscriber();
        $subscriber->email = $request->email;
        $subscriber->save();

        return response(['status' => 'success', 'message' => 'Successfully Subscribed To Our Newsletter']);
    }

    public function showProduct(string $slug): View
    {
        /**The reason for the with statement is that the frontend can load with all the
         * relationships and the original query at once otherwise known as eager loading.
         */
        $products = Product::with(['productImages', 'productSizes', 'productVariance'])
            ->where(['slug' => $slug, 'status' => 1])
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->firstOrFail();

        $relatedProducts = Product::where('category_id', $products->category_id)
            ->where('id', '!=', $products->id)->take(8)->latest()
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->get();

        $reviews = ProductRating::where(['product_id' => $products->id, 'status' => 1])
            ->orderBy('id', 'DESC')->paginate(5);

        $reviewCount = DB::select('SELECT COUNT(*) as count FROM product_ratings WHERE product_id = ?', [$products->id]);

        return view('frontend.pages.product-view', compact(
            'products',
            'relatedProducts',
            'reviews',
            'reviewCount'
        ));
    }

    public function loadProductModal($productId)
    {
        $products = Product::with(['productSizes', 'productVariance'])->findOrFail($productId);

        return view('frontend.layouts.ajax-files.product-popup-modal', compact('products'))->render();
    }

    function productReviewStore(Request $request)
    {
        $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'review' => ['required', 'max:500'],
            'product_id' => ['required', 'integer']
        ]);

        $user = Auth::user();

        $hasPurchased = $user->orders()->whereHas('orderItems', function ($query) use ($request) {
            $query->where('product_id', $request->product_id);
        })
            ->where('order_status', 'delivered')
            ->get();

        if (count($hasPurchased) == 0) {
            throw ValidationException::withMessages(['Please make an order to add a review!']);
        }

        $alreadyReviewed = ProductRating::where(['user_id' => $user->id, 'product_id' => $request->product_id])
            ->exists();

        if ($alreadyReviewed) {
            throw ValidationException::withMessages(['Already added a review for this product!']);
        }

        $review = new ProductRating();
        $review->user_id = $user->id;
        $review->rating = $request->rating;
        $review->review = $request->review;
        $review->product_id = $request->product_id;
        $review->save();

        toastr()->success('Review added for this product, awaiting approval');
        return redirect()->back();
    }

    function loadMoreReview(Request $request)
    {
        $reviews = ProductRating::where('status', 1)->paginate(6);
        if ($request->ajax()) {
            $view = view('frontend.pages.review-load-more', compact('reviews'))->render();
            return response()->json(['html' => $view]);
        }
        return view('frontend.pages.review', compact('reviews'));
    }

    function productIndex(Request $request)
    {
        $products = Product::where('status', 1)->orderBy('id', 'DESC');

        if ($request->has('search') && $request->filled('search')) {
            $products->where(function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('long_description', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('category') && $request->filled('category')) {
            $products->whereHas('category', function ($query) use ($request) {
                $query->where('slug', $request->category);
            });
        }

        $products = $products->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->paginate(12);

        $categories = Category::where('status', 1)->get();
        return view('frontend.pages.product', compact('products', 'categories'));
    }

    public function applyCoupon(Request $request)
    {
        $subtotal = $request->subtotal;
        $code = $request->code;
        $coupon = Coupon::where('code', $code)->first();

        if (!$coupon) {
            return response(['message' => 'Invalid coupon code'], 422);
        }
        if ($coupon->quantity <= 0) {
            return response(['message' => 'Coupon already used'], 422);
        }
        if ($coupon->expired_date < now()) {
            return response(['message' => 'Coupon has expired'], 422);
        }

        if ($coupon->discount_type === 'percent') {
            $discount = $subtotal * ($coupon->discount / 100);
            $discount = round($discount, 2);
        } elseif ($coupon->discount_type === 'amount') {
            $discount = $coupon->discount;
            $discount = round($discount, 2);
        }

        $finalTotal = $subtotal - $discount;

        session()->put('coupon', ['code' => $code, 'discount' => $discount]);
        return response([
            'message' => 'Coupon code added successfully',
            'finalTotal' => $finalTotal,
            'discount' => $discount,
            'coupon_code' => $code
        ]);
    }

    public function destroyCoupon()
    {
        try {
            session()->forget('coupon');

            return response(['message' => 'Coupon successfully removed', 'grand_cart_total' => grandCartTotal()]);
        } catch (\Exception $e) {
            logger($e);
            return response(['message' => 'Something went wrong in the frontend']);
        }
    }
}
