<?php
if (!$this->connection) {
            die("Database connection failed: " . mysqli_error($this->connection));
        }