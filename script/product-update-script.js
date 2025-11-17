new Vue({
    el:"#app-product-update",

    data(){
        return{
            max:null,

            start_date:"",
            start_time :"",
            finish_date:"",
            finish_time :"",

            name:"",

            location:"",

            addressNum:"",
            address : "",

            tel:null,

            detail : "",

            price:null,

            tags:[],

            toggleDateForm:false
        };
    },

    methods:{
        toggleForm()
        {
            this.toggleDateForm = !this.toggleDateForm;
        },

        setData( max, name, location, addressNum, address, tel, detail, price)
        {
            this.max = max;
            this.name = name;
            this.location = location;
            this.addressNum = addressNum;
            this.address = address;
            this.tel = tel;
            this.detail = detail;
            this.price = price;
        },

        deleteDate( index )
        {
            this.start_date.splice(index, 1);
            this.start_time.splice(index, 1);
            this.finish_date.splice(index, 1);
            this.finish_time.splice(index, 1);
        },
    },
    

    computed:{
        isDetailOver()
        {
            return this.detail.length > 1000;
        },

        isTime()
        {
            const timeReg = new RegExp(/^[0-9][:][0-5][0-9]|1[0-9][:][0-5][0-9]|2[0-3][:][0-5][0-9]$/);

            return !(timeReg.test(this.start_time) && timeReg.test(this.finish_time)) ;
        },

        isAddressNum()
        {
            const addressNumReg = new RegExp(/^[0-9][0-9][0-9][-][0-9][0-9][0-9][0-9]$/);

            return !addressNumReg.test(this.addressNum);
        },

        isTel()
        {
            const telReg = new RegExp(/[0-9]{1,}/);

            return !telReg.test(this.tel);
        },

        isTags()
        {
            return this.tags.length <= 3;
        },

        isDateTime()
        {
            return ( this.start_date != "0000-00-00" && this.finish_date != "0000-00-00" && this.isTime() );
        },

        isFullInput()
        {
            return !( (!this.isAddressNum || this.addressNum == "") && (!this.isTel || this.tel == null) && (!this.isDetailOver) && (this.isTags || this.tags.length == 0 ) )
        }
    }
});