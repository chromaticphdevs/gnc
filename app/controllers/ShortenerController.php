<?php 

    class ShortenerController extends Controller
    {
        public function __construct()
        {
            parent::__construct();
            $this->linkShortenerModel = model('LinkShortenerModel');
        }

        public function index($key) {
            $short = $this->linkShortenerModel->dbget([
                'shortened_key' => $key
            ]);

            $data = [
                'short' => $short,
                'html_description' => 'Cash Advance Membership',
                'html_keywords' => 'Cash Advance, Financing',
                'html_author' => 'Breakthrough Finance',
            ];

            return $this->view('shortener/index', $data);
        }
    }