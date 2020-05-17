import Vue from 'vue'
import axios from 'axios'

Vue.filter('currency', function (money) {
    return accounting.formatMoney(money, "Rp ", 2, ".", ",")
})

new Vue({
    el: '#app',
    data: {
        product: {},
        cart: {
            product_id: '',
            qty: 1,
        },
        listCart: [],
        submitCart: false,
        discount: {
            discountName: '',
            discountValue: '',
        },
        subTotal: '',
        total: '',
        cash: '',
        totalChange: '',
        search: '',
        products: [],
        categoryProduct: '',
        priceStatus: 'price',
        paymentType: ''
    },
    watch: {
        // 'product.id': function(){
        //     if (this.product.id) {
        //         this.getProduct();
        //     }
        // },
        'priceStatus': function(){
            this.getProductByCategory(this.categoryProduct);
        },
        'listCart': function(){
            this.totalCart();
        },
        'cash': function(){
            this.calculate();
        },
        'categoryProduct': function(){
            this.getProductByCategory(this.categoryProduct);
        },
        'paymentType': function(){
            if (this.paymentType != '') {
                this.cash = this.total;
            } else {
                this.cash = "";
            }
        }
    },
    mounted() {
        // this.allProducts();
        this.getCart();
        this.$refs.triggerCat.click();
    },
    created(){
        this.$on('searching', () => {
            axios.get('/api/search?q='+this.search, {
            params: {
                'price_status' : this.priceStatus
            }})
            .then((response) => {
                this.products = response.data
            })
            .catch((error) => {
                console.log(error);
            })
        })
    },
    computed:{
        checkImg(){
            return this.product.picture != null ? this.product.picture : 'images/cashierx/300x300.png';
        },
        totalPrice(){
            let keys = Object.keys(this.listCart);
            let total = 0;          
            keys.forEach(key => {
                let item = this.listCart[key];
                
                total += (parseInt(item.price) * item.qty)
            })

            return total;
        },
        priceStatusFormat()
        {
            return this.priceStatus != 'price' ? 'Harga Grab' : 'Harga Cafe';
        }
    },
    methods: {
        // getProduct(){
        //     axios.get(`/api/product/${this.product.id}`)
        //     .then((response) => {
        //         this.product = response.data
        //     })
        // },
        addToCart(){
            this.submitCart = true;

            axios.post('/api/cart', this.cart, {params: {'price_status': this.priceStatus}})
            .then((response) => {
                this.listCart = response.data,

                    this.cart.product_id = '',
                    this.cart.qty = 1
                    this.product = {
                        id: '',
                    }
                    $('#product_id').val('')
                    this.submitCart = false
                    $('#orderModal').modal('hide');
            })
            .catch((error) => {

            })
        },
        addDiscount(){
            axios.get('/api/discount', {params: {'name': this.discount.discountName}})
            .then((response) => {
                if (response.data.value != '') {
                    this.discount.discountValue = response.data.value;   
                    swal({
                        title: 'Sukses!',
                        text: `Diskon ${response.data.value}% Diterapkan`,
                        icon: 'success',
                        timer: 3000
                    });  
                }else{
                    this.discount.discountValue = '';
                    swal({
                        title: 'Gagal!',
                        text: 'Kode Diskon Tidak Ditemukan.',
                        icon: 'error',
                        timer: 3000
                    }); 
                }
                this.totalCart();
            })
            .catch((error) => {

            })
        },
        getCart(){
            axios.get('/api/cart')
            .then((response) => {
                this.listCart = response.data
            })
        },
        removeCart(id){
            swal({
                text: 'Apakah anda yakin menghapus data ini?', 
                buttons: {
                    cancel: true,
                    confirm: true,
                },
                preConfirm: () => {
                    return new Promise((resolve) => {
                        setTimeout(() => {
                            resolve()
                        }, 2000)
                    })
                },
                allowOutsideClick: () => !this.$swal.isLoading()
            }).then((result) => { 
                if (result) {
                    axios.delete(`/api/cart/${id}`)
                    .then((response) => {
                        this.getCart();
                    })
                    .catch ((error) => {
                        console.log(error);
                    })
                }
            })
        },
        totalCart()
        {
            if (this.discount.discountValue == "") {
                let keys = Object.keys(this.listCart);
                let total = 0;          
                keys.forEach(key => {
                    let item = this.listCart[key];
                    
                    total += (parseInt(item.price) * item.qty)
                })
    
                this.subTotal = total;
                this.total = total;
            } else {
                let keys = Object.keys(this.listCart);
                let subTotal = 0;   
                let total = 0;       
                keys.forEach(key => {
                    let item = this.listCart[key];
                    
                    subTotal += (parseInt(item.price) * item.qty)
                })
    
                total = subTotal - (subTotal / 100 * this.discount.discountValue)

                this.subTotal = subTotal;
                this.total = total;
            }
        },
        calculate()
        {
            let change = this.cash - this.total;

            this.totalChange = change;
        },
        // allProducts()
        // {
        //     axios.get('/api/products')
        //     .then((response) => {
        //         setTimeout(() => {
        //             this.products = response.data
        //         }, 1000)
                
        //     })
        //     .catch((error) => {

        //     })
        // },
        searching()
        {
            this.$emit('searching');
        },
        modalShow(id)
        {
            this.product.id = id;
            this.cart.product_id = id;
            
            $('#orderModal').modal('show');
        },
        getProductByCategory(id)
        {
            axios.get('/api/category/product/'+id, {
            params: {
                'price_status' : this.priceStatus
            }
            })
            .then((response) => {
                this.products = response.data
                // if (this.priceStatus == 'price_grab') {
                //     this.products.price = 
                // }
            })
            .catch((error) => {

            })
            // axios.get('/api/category/product/'+id)
            // .then((response) => {
            //     this.products = response.data
            // })
            // .catch((error) => {

            // })
        }
    }
})