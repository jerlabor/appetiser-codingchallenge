import VueToast from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';

Vue.use(VueToast,{
    position: 'top-right'
});

new Vue({
    el: '#app',
    data: {
        isProcessing: false,
        loaderHtml: `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="visually-hidden">Loading...</span>`,
        days: ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'],
        pagination: {
            page: 1,
            perPage: 15
        },
        dates: []
    },
    methods: {
        getDatesBetween(startDate, endDate, days = [],event = '') {
            const dates = [];
            const currentDate = new Date(startDate);
            while (currentDate <= new Date(endDate)) {
                dates.push({
                    date: currentDate.toLocaleString(),
                    event: days.includes(currentDate.getDay()) ? event : '',
                    label: `${currentDate.getDate()} ${new Intl.DateTimeFormat('en-US', { weekday: 'short' }).format(currentDate)}`
                });
                currentDate.setDate(currentDate.getDate() + 1);
            }
            return dates;
        },
        getCurrentMonthCalendar(){
            const date = new Date(), y = date.getFullYear(), m = date.getMonth();
            const firstDay = new Date(y, m, 1);
            const lastDay = new Date(y, m + 1, 0);
            this.dates = this.getDatesBetween(firstDay,lastDay);
        },
        async submit(e){
            try{
                this.isProcessing = true;
                const {data:{data:{event:{from,to,days,event}}}} = await axios.post('api/events', new FormData(e.target));
                const daysArr = days.map(day => Number(day.day));
                this.dates = this.getDatesBetween(from,to,daysArr,event);
                this.$toast.success('Event successfully saved');
            }catch(err){
                this.$toast.error(err.response.data.message);
            }
            this.isProcessing = false;
        }
    },
    computed: {
        calendarTitle() {
            if(this.dates.length === 0) return '';
            let label,from,to;
            from = new Date(this.dates[0].date);
            to = new Date(this.dates[this.dates.length - 1].date);
            label = from.getMonth() === to.getMonth() && from.getFullYear() === to.getFullYear() ? `${from.toLocaleString('default', { month: 'short' })} ${from.getFullYear()}` : `${from.toLocaleString('default', { month: 'short' })} ${from.getFullYear()} - ${to.toLocaleString('default', { month: 'short' })} ${to.getFullYear()}`;
            return label;
        },
        paginatedDates() {
            const start = (this.pagination.page - 1) * this.pagination.perPage;
            const end = this.pagination.page * this.pagination.perPage;

            return this.dates.slice(start,end);
        },
        maxPage() {
            return Math.ceil(this.dates.length / this.pagination.perPage);
        }
    },
    created() {
        this.getCurrentMonthCalendar();
    }
});
