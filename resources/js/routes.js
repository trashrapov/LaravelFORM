import AboutComponent from './components/AboutComponent.vue';
import FormComponent from './components/FormComponent.vue';
import NotFoundComponent from './components/NotFoundComponent.vue';

export const routes = {

	mode: 'history',

	linkActiveClass: 'font-weight-bold',

	routes: [

		{

			path: '*',

			component: NotFoundComponent,

		},

		{

			path: '/',

			component: FormComponent,			

		},

		{

			path: '/about',

			component: AboutComponent,

		}
	],

};