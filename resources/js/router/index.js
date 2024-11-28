import { createRouter, createWebHistory } from 'vue-router'
import authMiddleware from '@/middleware/auth.js';


const router = createRouter({
  history: createWebHistory(),
  routes: [
    {
      path: '/',
      name: 'Home',
      component: () => import('@/pages/Index.vue')
    },
    {
      path: '/login',
      name: 'Login',
      component: () => import('@/pages/Auth/Login.vue')
    },
    {
      path: '/dashboard',
      name: 'Dashboard',
      component: () => import('@/pages/Dashboard/Index.vue')
    },
    {
      path:'/analytics',
      name:'analytics',
      component: () => import('@/pages/Dashboard/Analytics.vue')
    },
    {
      path: '/pos',
      name: 'Pos',
      component: () => import('@/pages/Pos/Index.vue')
    },
    {
      path: '/products',
      name: 'Products',
      component: () => import('@/pages/Products/Index.vue')
    },
    {
      path: '/product/variations',
      name: 'ProductVariations',
      component: () => import('@/pages/Products/Variations.vue')
    },
    {
      path: '/create-product',
      name: 'CreateProduct',
      component: () => import('@/pages/Products/Add.vue')
    },
    {
      path: '/edit-product/:id',
      name: 'EditProduct',
      component: () => import('@/pages/Products/Edit.vue')
    },
    {
      path: '/edit-product-variation/:slug',
      name: 'EditProductVariation',
      component: () => import('@/pages/Products/SetVariation.vue')
    },
    {
      path: '/product-detail/:slug',
      name: 'Detail',
      component: () => import('@/pages/Products/Show.vue')
    },
    {
      path: '/category',
      name: 'Category',
      component: () => import('@/pages/Category/Index.vue')
    },
    {
      path: '/create-category',
      name: 'CreateCategory',
      component: () => import('@/pages/Category/Add.vue')

    },
    {
      path: '/edit-category/:id',
      name: 'EditCategory',
      component: () => import('@/pages/Category/Edit.vue')

    },
    {
      path: '/category/:id',
      name: 'ShowCategory',
      component: () => import('@/pages/Category/Show.vue')

    },
    {
      path: '/locations',
      name: 'Locations',
      component: () => import('@/pages/Location/Index.vue')

    },
    {
      path: '/locations/create-location',
      name: 'CreateLocations',
      component: () => import('@/pages/Location/Add.vue')

    },
    {
      path: '/locations/edit-location/:id',
      name: 'EditLocations',
      component: () => import('@/pages/Location/Add.vue')
    },
    {
      path: '/brand',
      name: 'Brand',
      component: () => import('@/pages/Brand/Index.vue')
    },
    {
      path: '/create-brand',
      name: 'CreateBrand',
      component: () => import('@/pages/Brand/Add.vue')
    },
      {
      path: '/stock',
      name: 'Stock',
      component: () => import('@/pages/Stock/Index.vue')
    },
    {
      path: '/customers',
      name: 'Customers',
      component: () => import('@/pages/Customers/Index.vue')
    },
    {
      path: '/create-customer',
      name: 'CreateCustomer',
      component: () => import('@/pages/Customers/Add.vue')
    },
    {
      path: '/edit-customer',
      name: 'EditCstomer',
      component: () => import('@/pages/Customers/Edit.vue')
    },
      {
      path: '/manager',
      name: 'Manager',
      component: () => import('@/pages/Manager/Index.vue')
    },
    {
      path: '/create-manager',
      name: 'CreateManager',
      component: () => import('@/pages/Manager/Add.vue')
    },
    {
      path: '/edit-manager',
      name: 'EditManager',
      component: () => import('@/pages/Manager/Edit.vue')
    },
    {
      path:'/admin',
      name: 'Admiin',
      component: () => import('@/pages/Admins/Index.vue'),
    },
    {
      path: '/order',
      name: 'Order',
      component: () => import('@/pages/Order/Index.vue')
    },
    {
      path:'/order/refund-request',
      name: 'RefundRequest',
      component: () => import('@/pages/Order/RefundRequest.vue')
    },
    {
      path:'/order-detail/:id',
      name: 'OrderDetail',
      component: () => import('@/pages/Order/Show.vue')
    },
    {
      path: '/shipping',
      name: 'Shipping',
      component: () => import('@/pages/Shipping/Index.vue')
    },
    {
      path: '/create-shipping',
      name: 'CreateShipping',
      component: () => import('@/pages/Shipping/Add.vue')
    },
    {
      path: '/edit-shipping/:id',
      name: 'EditShipping',
      component: () => import('@/pages/Shipping/Edit.vue')
    },
    {
      path: '/slider',
      name: 'Slider',
      component: () => import('@/pages/Slider/Index.vue')
    },
    {
      path: '/create-slider',
      name: 'CreateSlider',
      component: () => import('@/pages/Slider/Add.vue')
    },
    {
      path: '/edit-slider/:id',
      name: 'EditSlider',
      component: () => import('@/pages/Slider/Add.vue')
    },
      {
      path: '/advertise',
      name: 'Advertise',
      component: () => import('@/pages/Advertise/Index.vue')
    },
    {
      path: '/create-advertise',
      name: 'CreateAdvertise',
      component: () => import('@/pages/Advertise/Add.vue')
    },
    {
      path: '/edit-advertise',
      name: 'EditAdvertise',
      component: () => import('@/pages/Advertise/Edit.vue')
    },
    {
      path: '/blog',
      name: 'Blog',
      component: () => import('@/pages/Blog/Index.vue')
    },
    {
      path: '/custom-pages',
      name: 'CustomPages',
      component: () => import('@/pages/CustomPages/Index.vue')
    },
      {
      path: '/profile',
      name: 'Profile',
      component: () => import('@/pages/Profile/Index.vue')
    },
    {
      path: '/testimonials',
      name: 'Testimonials',
      component: () => import('@/pages/Testimonials/Index.vue')
    },
    {
      path: '/testimonials/create',
      name: 'AddTestimonials',
      component: () => import('@/pages/Testimonials/Create.vue')
    },
    {
      path: '/services',
      name: 'Services',
      component: () => import('@/pages/Services/Index.vue')
    },
    {
      path: '/services/create',
      name: 'AddService',
      component: () => import('@/pages/Services/Create.vue')
    },
    {
      path: '/setting',
      name: 'Setting',
      component: () => import('@/pages/Setting/Index.vue')
    },
    {
      path: '/messages',
      name: 'Messages',
      component: () => import('@/pages/Message/Index.vue')
    },
    {
      path: '/profile-setting',
      name: 'ProfileSetting',
      component: () => import('@/pages/Setting/ProfileSetting.vue')
    },
    {
      path: '/app-setting',
      name: 'AppSetting',
      component: () => import('@/pages/Setting/AppSetting.vue')
    },
    {
      path: '/home-setting',
      name: 'HomeSetting',
      component: () => import('@/pages/Setting/HomeSetting.vue')
    },
    {
      path: '/header-setting',
      name: 'HeaderSetting',
      component: () => import('@/pages/Setting/HeaderSetting.vue')
    },
    {
      path: '/footer-setting',
      name: 'FooterppSetting',
      component: () => import('@/pages/Setting/FooterSetting.vue')
    },
    {
      path: '/pages',
      name:'Pages',
      component: () => import('@/pages/CustomPages/Index.vue'),
    },
    {
      path: '/create-page',
      name:'CreatePage',
      component: () => import('@/pages/CustomPages/Add.vue'),
    },
    {
      path: '/edit-page/:id',
      name:'EditPage',
      component: () => import('@/pages/CustomPages/Edit.vue'),
    },
    {
      path: '/all-review',
      name:'AllReview',
      component: () => import('@/pages/Reviews/Index.vue'),
    },
    {
      path: '/create-review',
      name:'CreateReview',
      component: () => import('@/pages/Reviews/Add.vue'),
    },
    {
      path: '/edit-page/:id',
      name:'EditPage',
      component: () => import('@/pages/CustomPages/Edit.vue'),
    },
    {
      path: '/home-sections',
      name:'HomeSection',
      component: () => import('@/pages/HomeSection/Index.vue'),
    },
    {
      path: '/create-home-sections',
      name:'CreateHomeSection',
      component: () => import('@/pages/HomeSection/Add.vue'),
    },
    // -- customized cakes --
    {
      path: '/custom-cakes',
      name:'CustomCakes',
      component: () => import('@/pages/CustomCakes/Index.vue'),
    },
    {
      path: '/custom-cakes/create',
      name:'CustomCakeCreate',
      component: () => import('@/pages/CustomCakes/CustomCakeCreate.vue'),
    },
    {
      path: '/custom-cake-flavors',
      name:'CustomCakeFlavors',
      component: () => import('@/pages/CustomCakes/Flavors.vue'),
    },
    {
      path: '/custom-cake-flavors/create',
      name:'CustomCakeFlavorCreate',
      component: () => import('@/pages/CustomCakes/CustomCakeFlavorCreate.vue'),
    },
    {
      path: '/custom-cake-orders',
      name:'CustomCakeOrders',
      component: () => import('@/pages/CustomCakes/Order.vue'),
    }
  ]
})

router.beforeEach(authMiddleware)
export default router