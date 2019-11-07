<?php

// Instalacion y Desinstalacion del plugin
class XtubeInstall {
    // Instalacion
    public function plugin_activation() {
        global $wpdb;
        
        $table_videos = 'CREATE TABLE IF NOT EXISTS XTB_VIDEOS (
            id INT AUTO_INCREMENT NOT NULL,
            url TEXT NOT NULL,
            PRIMARY KEY(id)
        ) ENGINE=InnoDB;';
        
        $table_posts = 'CREATE TABLE IF NOT EXISTS XTB_POSTS (
            id INT AUTO_INCREMENT NOT NULL,
            video_id INT NOT NULL,
            title VARCHAR(50) NOT NULL,
            post VARCHAR(255) NOT NULL,
            posted_at TIMESTAMP NOT NULL,
            PRIMARY KEY(id),
            FOREIGN KEY(video_id) REFERENCES XTB_VIDEOS(id)
        ) ENGINE=InnoDB;';

        $table_settings = 'CREATE TABLE IF NOT EXISTS XTB_SETTINGS (
            name VARCHAR(50) NOT NULL UNIQUE,
            value TEXT,
            description TEXT,
            PRIMARY KEY(name)
        ) ENGINE=InnoDB;';

        $table_tags = 'CREATE TABLE IF NOT EXISTS XTB_TAGS (
            id INT AUTO_INCREMENT NOT NULL,
            name VARCHAR(50) NOT NULL UNIQUE,
            description TEXT,
            PRIMARY KEY(id)
        ) ENGINE=InnoDB;';

        //$table_comments;
        $wpdb->query($table_tags);
        $wpdb->query($table_settings);
        //$wpdb->query($table_comments);
        $wpdb->query($table_videos);
        $wpdb->query($table_posts);
    }

    // Desinstalacion
    public function plugin_deactivation() {
        global $wpdb;
        $wpdb->query('DROP TABLE IF EXISTS XTB_POSTS');
        $wpdb->query('DROP TABLE IF EXISTS XTB_VIDEOS');
        $wpdb->query('DROP TABLE IF EXISTS XTB_SETTINGS');
    }
}