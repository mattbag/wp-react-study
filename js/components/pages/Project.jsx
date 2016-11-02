import React from 'react'
import { findWhere } from 'underscore'
import { fetchProject } from '../../actions'
import Project from '../ProjectPage'

module.exports = React.createClass({

	componentDidMount: function() {
		this.props.dispatch( fetchProject( this.props.routeParams.slug ) )
	},

	render: function() {
		// console.log(this.props.routeParams);
		var project = findWhere( this.props.posts.projects, { slug: this.props.routeParams.slug } )

		if ( ! project ) {
			return (
				<div className="loading-wrap">
					<div className="loading"><span className="fa fa-bomb fa-spin "></span> LOADING</div>
				</div>
			)
		}

		return (
			<ul className="Posts">
				<li>
					<Project {...project} />
				</li>
			</ul>

		)
	}
})
