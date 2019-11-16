<?php

// Instalacion y Desinstalacion del plugin
class XtubeInstall {
    // Instalacion
    public function plugin_activation() {
        global $wpdb;
        
        $table_videos = 'CREATE TABLE IF NOT EXISTS XTB_VIDEOS (
            id INT AUTO_INCREMENT NOT NULL,
            url VARCHAR(300) NOT NULL UNIQUE,
            iframe VARCHAR(300) NOT NULL, 
            title VARCHAR(255) NOT NULL,
            img_src VARCHAR(300) NOT NULL,
            duration VARCHAR(10) NOT NULL DEFAULT(0),
            views INT NOT NULL DEFAULT(0),
            upvotes INT NOT NULL DEFAULT(0),
            downvotes INT NOT NULL DEFAULT(0),
            posted_at TIMESTAMP NOT NULL DEFAULT (CURRENT_TIMESTAMP), 
            PRIMARY KEY(id)
        ) ENGINE=InnoDB;';

        $table_video_tags = 'CREATE TABLE IF NOT EXISTS XTB_VIDEO_TAGS (
            id INT AUTO_INCREMENT NOT NULL,
            video_id INT NOT NULL,
            tag_id INT NOT NULL,
            PRIMARY KEY(id),
            FOREIGN KEY(video_id) REFERENCES XTB_VIDEOS(id) ON DELETE CASCADE ON UPDATE CASCADE,
            FOREIGN KEY(tag_id) REFERENCES XTB_TAGS(id) ON DELETE CASCADE ON UPDATE CASCADE
        ) ENGINE=InnoDB;';
        
        $table_settings = 'CREATE TABLE IF NOT EXISTS XTB_SETTINGS (
            name VARCHAR(50) NOT NULL UNIQUE,
            value VARCHAR(255),
            description TEXT,
            PRIMARY KEY(name)
        ) ENGINE=InnoDB;';

        $table_tags = 'CREATE TABLE IF NOT EXISTS XTB_TAGS (
            id INT AUTO_INCREMENT NOT NULL,
            name VARCHAR(50) NOT NULL UNIQUE,
            PRIMARY KEY(id)
        ) ENGINE=InnoDB;';

        $table_reported_videos = 'CREATE TABLE IF NOT EXISTS XTB_VIDEO_REPORTS (
            id INT AUTO_INCREMENT NOT NULL,
            video_id INT NOT NULL,
            reason TEXT,
            PRIMARY KEY(id),
            FOREIGN KEY(video_id) REFERENCES XTB_VIDEOS(id) ON DELETE CASCADE ON UPDATE CASCADE
        ) ENGINE=InnoDB;';

        $table_video_votes_ip = 'CREATE TABLE IF NOT EXISTS XTB_VIDEO_VOTES_IP (
            id INT AUTO_INCREMENT NOT NULL,
            video_id INT NOT NULL,
            ip VARCHAR(20),
            PRIMARY KEY(id),
            FOREIGN KEY(video_id) REFERENCES XTB_VIDEOS(id) ON DELETE CASCADE ON UPDATE CASCADE
        ) ENGINE=InnoDB;';

        $table_video_views_ip = 'CREATE TABLE IF NOT EXISTS XTB_VIDEO_VIEWS_IP (
            id INT AUTO_INCREMENT NOT NULL,
            video_id INT NOT NULL,
            ip VARCHAR(20),
            PRIMARY KEY(id),
            FOREIGN KEY(video_id) REFERENCES XTB_VIDEOS(id) ON DELETE CASCADE ON UPDATE CASCADE
        ) ENGINE=InnoDB;';

        $wpdb->query($table_settings);
        $wpdb->query($table_videos);
        $wpdb->query($table_tags);
        $wpdb->query($table_video_tags);
        $wpdb->query($table_reported_videos);
        $wpdb->query($table_video_votes_ip);
        $wpdb->query($table_video_views_ip);

        $this->add_data('XTB_SETTINGS', array(
            'name' => 'videos_per_page',
            'value' => '8',
            'description' => 'The numbers of videos that every page can show.'
        ));
    }

    public function add_data($table, $data) {
        global $wpdb;
        $wpdb->insert($table, $data);
    }

    // Desinstalacion
    public function plugin_deactivation() {
        global $wpdb;
        $wpdb->query('DROP TABLE IF EXISTS XTB_VIDEO_TAGS');
        $wpdb->query('DROP TABLE IF EXISTS XTB_VIDEO_REPORTS');
        $wpdb->query('DROP TABLE IF EXISTS XTB_VIDEO_VOTES_IP');
        $wpdb->query('DROP TABLE IF EXISTS XTB_VIDEO_VIEWS_IP');
        $wpdb->query('DROP TABLE IF EXISTS XTB_SETTINGS');
        $wpdb->query('DROP TABLE IF EXISTS XTB_POSTS');
        $wpdb->query('DROP TABLE IF EXISTS XTB_TAGS');
        $wpdb->query('DROP TABLE IF EXISTS XTB_VIDEOS');
    }
}