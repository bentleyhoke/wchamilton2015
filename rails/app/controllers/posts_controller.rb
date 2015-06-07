class PostsController < ApplicationController
	def index
		@callback_url = "http://wchamilton2015rails.bentleyhoke.webfactional.com/"
		@consumer = oauth_consumer

		session["secret"] = nil
		session["token"] = nil
		session["access_secret"] = nil
		session["access_token"] = nil

		
		@request_token = @consumer.get_request_token(:oauth_callback => @callback_url)
		session["secret"] = @request_token.secret
		session["token"] = @request_token.token

		@callback_url = "http://wchamilton2015rails.bentleyhoke.webfactional.com/posts/new"
		redirect_to @request_token.authorize_url(:oauth_callback => @callback_url)
	end

	def new
		@consumer = oauth_consumer
		if params[:oauth_verifier]
			session["oauth_verifier"] = params[:oauth_verifier]
			@request_token = OAuth::RequestToken.new(@consumer, session["token"], session["secret"])
			@access_token = @request_token.get_access_token({:oauth_verifier => params[:oauth_verifier]})
			session["access_secret"] = @access_token.secret
			session["access_token"] = @access_token.token
		end
	end

	def create
		@consumer = oauth_consumer
		@access_token = OAuth::AccessToken.new(@consumer, session["access_token"], session["access_secret"])

		map = "https://maps.googleapis.com/maps/api/staticmap?center=#{params[:lat]},#{params[:lng]}&amp;size=600x400&amp;zoom=9&amp;markers=color:blue||#{params[:lat]},#{params[:lng]}"
		@mapimg = "<img src=\"#{map.html_safe}\" alt=\"map of WordCamp location \" />"
		
		postcontents = {
			:title => params[:title],
			:status => 'publish',
            :content_raw => "#{@mapimg.html_safe}<br>#{params[:body]}",
            :excerpt_raw => 'Excerpt, not raw'
        }
        @dev = postcontents
		@response = @access_token.post('http://wchamilton2015.bentleyhoke.webfactional.com/wp-json/posts/', postcontents, { 'Content-Type' => 'application/x-www-form-urlencoded' })
		flash[:notice] = 'Note Added.'
		redirect_to '/posts/new'
	end




	private

	def oauth_consumer
		OAuth::Consumer.new(
			"KEY",
			"SECRET",
			:scheme				=> :body,
			:http_method		=> :post,
			:site               => "http://wchamilton2015.bentleyhoke.webfactional.com",
            :request_token_path => '/oauth1/request',
            :authorize_path     => '/oauth1/authorize',
            :access_token_path  => '/oauth1/access',
            :oauth_version 		=> "1.0"
        )
	end
end
