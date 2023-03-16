# Use the official Nginx image as the base image
FROM nginx:latest

# Remove the default Nginx configuration
RUN rm /etc/nginx/conf.d/default.conf

# Copy the custom Nginx configuration
COPY ./default.conf /etc/nginx/conf.d/
