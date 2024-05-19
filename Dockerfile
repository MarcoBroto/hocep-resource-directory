# Use the official MySQL 8.0 image from Docker Hub
FROM mysql:8.0

# Set environment variables for MySQL
ENV MYSQL_ROOT_PASSWORD=Mysqllocalhost123!
ENV MYSQL_DATABASE=oc_db
ENV MYSQL_USER=tester
ENV MYSQL_PASSWORD=Mysqllocalhost123!

# Copy the SQL scripts to initialize the database and run additional SQL script
COPY src/sql/init.sql /docker-entrypoint-initdb.d/
COPY src/sql/01-createSchema.sql /docker-entrypoint-initdb.d/
COPY src/sql/02-createViews.sql /docker-entrypoint-initdb.d/
COPY src/sql/03-createProcedures.sql /docker-entrypoint-initdb.d/

# Expose port 3306 to allow external connections
EXPOSE 3306

# Define a volume for MySQL data
VOLUME /var/lib/mysql

# Run additional SQL script after MySQL initialization
# RUN service mysql start

# Start MySQL server
CMD ["mysqld"]
