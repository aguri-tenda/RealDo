new Vue({
    el:"#app-product-insert",

    data(){
        return{
            max:null,

            date:"",
            time : "",

            name:"",

            location:"",

            addressNum:"",
            address : "",

            tel:"",

            detail : "",

            price:null,

            tags:[]
        };
    },
    

    computed:{
        isDetailOver()
        {
            return this.detail.length > 1000;
        },

        isTime()
        {
            const timeReg = new RegExp(/^[0-9][:][0-5][0-9]|1[0-9][:][0-5][0-9]|2[0-3][:][0-5][0-9]$/);

            return !timeReg.test(this.time);
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
            return 0 < this.tags.length && this.tags.length <= 3;
        },

        isFullInput()
        {
            return !( (this.max != null) && (this.date != null) && !(this.isTime) && (this.name != null) && (this.location!=null) && (this.address != null) && !(this.isAddressNum) && !(this.isTel) && !(this.isDetailOver) && (this.price!=null) && (this.isTags) )
        }
    }
});