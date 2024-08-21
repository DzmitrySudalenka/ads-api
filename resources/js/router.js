import Vue from 'vue';
import Router from 'vue-router';
import AdList from '@/components/AdList.vue';
import AdDetail from '@/components/AdDetail.vue';

Vue.use(Router);

export default new Router({
  mode: 'history',
  routes: [
    {
      path: '/',
      name: 'AdList',
      component: AdList,
    },
    {
      path: '/ads/:id',
      name: 'AdDetail',
      component: AdDetail,
      props: true,
    },
  ],
});
