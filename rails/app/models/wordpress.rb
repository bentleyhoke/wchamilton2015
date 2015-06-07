class Wordpress
  include HTTParty

  def getPage(id)
    response = self.class.get("http://wchamilton2015.bentleyhoke.webfactional.com/wp-json/wp/v2/posts/#{URI::escape(id)}")
    data = response
    if data
    	return {title:data['title']['rendered'], content:data['content']['rendered']}
    else
    	return nil
    end
  end

  def createPost()
  	response = self.class.post("http://wchamilton2015.bentleyhoke.webfactional.com/wp-json/wp/v2/posts/",
    	:body => {
        "title" => "Test Title 6",
        "content_raw" => "Content - really raw",
        "excerpt_raw" => "Excerpt"
      }.to_json,
      :basic_auth => { username: "admin", password: "msMZPqny" },
    	:headers => {
        "Content-Type" => "application/json"
      })
    return response
  end

end