import React from 'react'
import { fetchProjects } from '../../actions'
import { Link } from 'react-router'
import Project from '../ProjectPage'

module.exports = React.createClass({

	componentDidMount: function() {
		this.props.dispatch( fetchProjects() )
	},

	render: function() {
		if ( ! this.props.posts.projects.length ) {
			return (
				<div className="loading-wrap">
					<div className="loading"><span className="fa fa-bomb fa-spin"></span> ISSUE:</div>
				<br/>
					<h2>Can't figure how to pop the featured image from a cpt</h2>
				</div>
			)
		}
		return (
			<ul className="Posts">
				{this.props.posts.projects.map( post => {
					// console.log(post.better_featured_image.source_url);
					// var featured_url = post.better_featured_image.source_url;
					// console.log(post._embedded['http://v2.wp-api.org/featuredmedia'][0].source_url);
					console.log(post._embedded['wp:featuredmedia']);
					return <li
					key={"project_id_" + post.id}
					>
						{/* <Project {...post} /> */}
					{/* <img src={featured_url} alt={post.title.rendered}/> */}
					{/* <img src={post._embedded['http://v2.wp-api.org/featuredmedia'][0].source_url} alt={post.title.rendered}/> */}

					</li>
				})}
			</ul>
		)
	}
})
