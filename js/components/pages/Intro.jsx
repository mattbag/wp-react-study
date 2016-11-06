import React from 'react'
import { fetchProjects } from '../../actions'
import { Link } from 'react-router'

// const URL = location.href;

module.exports = React.createClass({

	componentDidMount: function() {
		// this.props.dispatch( fetchProjects() )
	},
	render: function() {
		// console.log( this.props.posts.projects )
		return (
			<div className="Intro">
				<img src="/wp-content/themes/react/img/faceconic.png" width="300" alt="logo"/>
				<h1>Born to be wise</h1>
				<h2>A world traveller + web designer and developer</h2>
				{/* <h2>Learn about the <a href="http://wp-api.org/" target="_blank" className="highlight">WordPress REST API</a> from the team building it and the people using it.<br />
				28th January 2016, Conway Hall, London</h2> */}
				{/* <video webkit-playsinline="" autoPlay="yes" loop="yes">
					<source src="/content/themes/endurance/videos/dayofrest.mp4" type="video/mp4" />
				</video> */}

				{/* <ul className="sponsors-list">
					{this.props.posts.sponsors.map( sponsor => {
						return <li key={sponsor.id}>
							<Link to="/sponsors/">
								{sponsor.white_logo
									?	<img src={sponsor._embedded['wp:whitelogo'][0].source_url} />
									:	<img src={sponsor._embedded['https://api.w.org/featuredmedia'][0].source_url} />
									}
							</Link>
						</li>
					})}
				</ul> */}
			</div>
		)
	}
})
