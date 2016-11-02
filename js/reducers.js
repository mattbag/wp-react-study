import { combineReducers } from 'redux'
import ObjectAssign from 'object-assign'
import { routerStateReducer } from 'redux-router';
import { findWhere } from 'underscore'

function posts( state = { projects:[], speakers: [], posts: [], pages: [], pointsOfInterest: [], sponsors: [] }, action ) {
	switch( action.type ) {
		case 'UPDATE_PROJECTS':
			state.projects = action.projects
			break
		case 'UPDATE_PROJECT':
			if ( ! findWhere( state.projects, { id: action.project.id } ) ) {
				state.projects.push( action.projects );
			}
			break
		case 'UPDATE_SPEAKERS':
			state.speakers = action.speakers
			break
		case 'UPDATE_SPEAKER':
			if ( ! findWhere( state.speakers, { id: action.speaker.id } ) ) {
				state.speakers.push( action.speaker );
			}
			break
		case 'UPDATE_SPONSORS':
			state.sponsors = action.sponsors
			break
		case 'UPDATE_POINTS_OF_INTEREST':
			state.pointsOfInterest = action.pointsOfInterest
			break
		case 'UPDATE_POSTS':
			state.posts = action.posts
			break
		case 'UPDATE_POST':
			if ( ! findWhere( state.posts, { id: action.post.id } ) ) {
				state.posts.push( action.post );
			}
			break;
		case 'UPDATE_PAGES':
			state.pages = action.pages
			break
		case 'UPDATE_PAGE':
			if ( ! findWhere( state.pages, { id: action.page.id } ) ) {
				state.pages.push( action.page );
			}
			break;
	}
	return state
}

function menu( state = {}, action ) {

	return {
		items: [
			{
				name: "Home",
				url: "/"
			},
			{
				name: "History",
				url: "/page/history/"
			},
			{
				name: "Projects",
				url: "/projects/"
			},
			// {
			// 	name: "Speakers",
			// 	url: "/speakers/"
			// },
			// {
			// 	name: "Schedule",
			// 	url: "/news/schedule/"
			// },
			{
				name: "News",
				url: "/news/"
			},
		// 	{
		// 		name: "Sponsors",
		// 		url: "/sponsors/"
		// 	},
		// 	{
		// 		name: "Hack Day",
		// 		url: "/page/hack-day/"
		// 	},
		// 	{
		// 		name: "Press",
		// 		url: "/page/press/"
		// 	},
			// {
			// 	name: "Contact",
			// 	url: "/page/contact/"
			// }
		]
	}
}

function display( state = { consoleExpanded: false, showingMenu: false, isGoingBack: false }, action ) {

	switch( action.type ) {
		case 'TOGGLED_CONSOLE':
			state.consoleExpanded = ! state.consoleExpanded
			break
		case 'TOGGLE_MENU':
			state.showingMenu = ! state.showingMenu
			break
		case '@@reduxReactRouter/routerDidChange':
			state.showingMenu = false
			break
	}

	return state
}

var reducers = combineReducers({
	menu,
	router: routerStateReducer,
	posts,
	display
})

module.exports = reducers
