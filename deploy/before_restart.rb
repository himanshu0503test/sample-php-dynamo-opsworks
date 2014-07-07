require 'json'

Chef::Log.info('Generating aws.json configuration file')

aws_config = {
  :includes => ['_aws'],
  :services => {
    :default_settings => {
      :params => {
        :key => node[:dynamodb][:aws_key],
        :secret => node[:dynamodb][:aws_secret],
        :region => node[:dynamodb][:region]
      }
    }
  }
}

aws_file_path = ::File.join(release_path, 'aws.json')
file aws_file_path do
  content aws_config.to_json
  owner new_resource.user
  group new_resource.group
  mode 00440
end
