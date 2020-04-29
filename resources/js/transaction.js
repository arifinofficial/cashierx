import Vue from 'vue'
import axios from 'axios'

Vue.filter('currency', function (money) {
    return accounting.formatMoney(money, "Rp ", 2, ".", ",")
})

new Vue({
    el: '#app',
    data: {
        product: {
            id: '',
            price: '',
            name: '',
            picture: '',
        },
        cart: {
            product_id: '',
            qty: 1,
        },
        listCart: [],
        submitCart: false,
        total: '',
        cash: '',
        totalChange: '',
        search: '',
        products: [],
    },
    watch: {
        'product.id': function(){
            if (this.product.id) {
                this.getProduct();
            }
        },
        'listCart': function(){
            this.totalCart();
        },
        'cash': function(){
            this.calculate();
        }
    },
    mounted() {
        this.allProducts();
        this.getCart();
    },
    created(){
        this.$on('searching', () => {
            axios.get('/api/search?q='+this.search)
            .then((response) => {
                this.products = response.data
            })
            .catch((error) => {

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
        }
    },
    methods: {
        getProduct(){
            axios.get(`/api/product/${this.product.id}`)
            .then((response) => {
                this.product = response.data
            })
        },
        addToCart(){
            this.submitCart = true;

            axios.post('/api/cart', this.cart)
            .then((response) => {
                this.listCart = response.data,

                    this.cart.product_id = '',
                    this.cart.qty = 1
                    this.product = {
                        id: '',
                        qty: '',
                        price: '',
                        name: '',
                        picture: '',
                    }
                    $('#product_id').val('')
                    this.submitCart = false
                    $('#orderModal').modal('hide');
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
            let keys = Object.keys(this.listCart);
            let total = 0;          
            keys.forEach(key => {
                let item = this.listCart[key];
                
                total += (parseInt(item.price) * item.qty)
            })

            this.total = total;
        },
        calculate()
        {
            let change = this.cash - this.total;

            this.totalChange = change;
        },
        allProducts()
        {
            axios.get('/api/products')
            .then((response) => {
                setTimeout(() => {
                    this.products = response.data
                }, 1000)
            })
            .catch((error) => {

            })
        },
        searching()
        {
            this.$emit('searching');
        },
        modalShow(id)
        {
            this.product.id = id;
            this.cart.product_id = id;
            
            $('#orderModal').modal('show');
        }
    }
})