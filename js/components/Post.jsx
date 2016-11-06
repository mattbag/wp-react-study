import React from 'react'
import { Link } from 'react-router'
// this is the post for the list-posts.jsx
module.exports = React.createClass({

	propTypes: {
		title: React.PropTypes.object.isRequired,
		content: React.PropTypes.object.isRequired,
		date: React.PropTypes.string.isRequired,
		slug: React.PropTypes.string.isRequired
	},

	render: function() {
		return (
			<div className="Post">
				<h1><Link to={'/news/' + this.props.slug }>{this.props.title.rendered}</Link></h1>
				{/* <span className="date">{this.props.date}</span> */}
				<Link to={'/news/' + this.props.slug }>
				<img src={this.props.better_featured_image.source_url} alt={this.props.title.rendered}/>
				</Link>

				{/* <div dangerouslySetInnerHTML={{__html:this.props.content.rendered}} /> */}
			</div>
		)
	}
})
