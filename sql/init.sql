create table areas
(
  id      int auto_increment
    primary key,
  name    varchar(200)     not null comment 'エリア（カテゴリ２）名',
  `order` int(2) default 1 not null comment '表示順'
)
  comment 'エリア（カテゴリ２）' collate = utf8_unicode_ci;

create table attachments
(
  id                int auto_increment
    primary key,
  model             text collate utf8_unicode_ci not null,
  model_id          int                          not null,
  field_name        text collate utf8_unicode_ci not null,
  file_name         text collate utf8_unicode_ci not null,
  file_content_type text collate utf8_unicode_ci not null,
  file_size         int                          not null,
  file_object       text collate utf8_unicode_ci null,
  created           datetime                     not null,
  modified          datetime                     not null
)
  comment '画像アップロード用です' engine = MyISAM;

create table backed_projects
(
  id               int auto_increment
    primary key,
  project_id       int                                                null comment 'プロジェクトID',
  user_id          int                                                null comment 'ユーザID',
  backing_level_id int                                                null comment '支援パターンID',
  invest_amount    varchar(50) collate utf8_unicode_ci                not null comment '支援金額',
  comment          text collate utf8_unicode_ci                       not null comment '支援コメント',
  stripe_charge_id varchar(255)                                       null comment 'StripeのChargeのID',
  status           varchar(30) collate utf8_unicode_ci default '作成完了' not null comment '決済ステータス',
  created          datetime                                           null comment 'データ作成日時',
  modified         datetime                                           null comment 'データ更新日時',
  manual_flag      tinyint(1)                          default 0      not null comment '手動登録フラグ',
  bank_flag        tinyint(1)                          default 0      not null,
  bank_paid_flag   tinyint(1)                          default 1      not null
)
  comment '決済データ';

create table backing_levels
(
  id            int auto_increment
    primary key,
  project_id    int              null comment 'プロジェクトID',
  name          varchar(100)     not null comment '支援パターン名',
  invest_amount varchar(200)     not null comment '最低支援額',
  return_amount text             not null comment 'リターン内容',
  max_count     int(5)           null comment '最大支援数',
  now_count     int(5) default 0 not null comment '現在の支援数',
  delivery      int(1) default 1 null comment 'リターン方法',
  created       datetime         null comment 'データ作成日時',
  modified      datetime         null comment 'データ更新日時'
)
  comment '支援パターン（リターン内容）' collate = utf8_unicode_ci;

create table categories
(
  id      int auto_increment
    primary key,
  name    varchar(200)     not null comment 'カテゴリ１名',
  `order` int(2) default 1 not null comment '表示順'
)
  comment 'カテゴリ１' collate = utf8_unicode_ci;

create table comments
(
  id         int auto_increment
    primary key,
  user_id    int      null comment 'ユーザID',
  project_id int      null comment 'プロジェクトID',
  comment    text     not null comment 'コメント',
  created    datetime null comment 'データ作成日時'
)
  comment 'コメント' collate = utf8_unicode_ci;

create table favourite_projects
(
  id         int auto_increment
    primary key,
  user_id    int         null comment 'ユーザID',
  project_id int         null comment 'プロジェクトID',
  backed     varchar(20) not null,
  created    datetime    null comment 'データ生成日時'
)
  comment 'お気に入りプロジェクト' collate = utf8_unicode_ci;

create table mail_auths
(
  id       int auto_increment
    primary key,
  email    varchar(255) not null comment 'メールアドレス',
  token    varchar(255) not null comment 'トークン',
  user_id  int(10)      null comment 'ユーザID',
  modified datetime     not null comment 'データ更新日時'
)
  comment 'メールアドレス認証用' collate = utf8_unicode_ci;

create table message_pairs
(
  message_pair_id  varchar(23)          not null comment 'メッセージ送受信者ペアID'
    primary key,
  last_sender_id   int                  not null comment '最後の送信者',
  last_receiver_id int                  not null comment '最後の受信者',
  read_flag        tinyint(1) default 0 not null comment '既読フラグ',
  modified         datetime             not null comment 'データ更新日時'
)
  comment 'メッセージ送受信者ペア' collate = utf8_unicode_ci;

create table messages
(
  id              int auto_increment
    primary key,
  message_pair_id varchar(10) not null comment 'メッセージ送受信者ペアID',
  from_id         int         not null comment '送信者ID',
  to_id           int         not null comment '受信者ID',
  content         text        not null comment 'メッセージ文',
  created         datetime    null comment 'データ作成日時'
)
  comment 'メッセージ' collate = utf8_unicode_ci;

create table project_content_orders
(
  project_id int(10) auto_increment comment 'プロジェクトID'
    primary key,
  `order`    text not null comment '表示順'
)
  comment 'プロジェクト詳細のコンテンツの表示順' collate = utf8_unicode_ci;

create table project_contents
(
  id          int(10) auto_increment
    primary key,
  project_id  int(10)                       not null comment 'プロジェクトID',
  open        int(4)      default 0         not null comment '公開ステータス',
  type        varchar(20) default 'text'    not null comment 'コンテンツ種別',
  txt_content text                          null comment 'テキストコンテンツ内容',
  movie_type  varchar(10) default 'youtube' not null comment '動画種別',
  movie_code  varchar(50)                   null comment '動画コード',
  img_caption varchar(100)                  null comment '画像キャプション'
)
  comment 'プロジェクト詳細のコンテンツ' collate = utf8_unicode_ci;

create table projects
(
  id                    int auto_increment
    primary key,
  project_name          varchar(200)                  not null comment 'プロジェクト名',
  category_id           int                           null comment 'カテゴリ１ID',
  area_id               int(10)                       null comment 'エリアID',
  description           text                          not null comment 'プロジェクト概要',
  goal_amount           varchar(100)                  not null comment '目標金額',
  collection_term       int(2)      default 60        not null comment '募集期間（日）',
  collection_start_date datetime                      null comment '募集開始日時',
  collection_end_date   datetime                      null comment '募集終了日時',
  thumbnail_type        int(1)      default 1         not null comment 'サムネイル種別',
  thumbnail_movie_type  varchar(10) default 'youtube' null comment 'サムネイルの動画種別',
  thumbnail_movie_code  varchar(50)                   null comment 'サムネイルの動画コード',
  user_id               int                           null comment 'ユーザID',
  opened                varchar(3)  default 'no'      not null comment '公開ステータス',
  backers               int         default 0         null comment '支援者数',
  comment_cnt           int(4)      default 0         not null comment 'コメント数',
  report_cnt            int(3)      default 0         not null comment '活動報告数',
  collected_amount      int(10)     default 0         null comment '現在の支援総額',
  max_back_level        varchar(20) default '0'       not null comment '支援パターン数',
  created               datetime                      null comment 'データ作成日時',
  modified              datetime                      null comment 'データ更新日時',
  active                varchar(3)  default 'yes'     not null comment '募集中',
  stop                  tinyint(1)  default 0         not null comment '公開停止ステータス',
  `return`              text                          not null comment 'リターン概要',
  contact               text                          not null comment 'プロジェクト起案者の連絡先',
  rule                  tinyint(1)  default 0         not null comment '利用規約同意有無',
  site_fee              int(2)                        null comment 'サイト手数料率',
  site_price            int(10)     default 0         not null comment 'サイト手数料',
  project_owner_price   int(10)     default 0         not null comment 'プロジェクト起案者への支払額'
)
  comment 'プロジェクト' collate = utf8_unicode_ci;

create table report_content_orders
(
  report_id int(10) auto_increment comment '活動報告ID'
    primary key,
  `order`   text not null comment '表示順'
)
  comment '活動報告詳細コンテンツの表示順' collate = utf8_unicode_ci;

create table report_contents
(
  id          int(10) auto_increment
    primary key,
  report_id   int(10)                       not null comment '活動報告ID',
  type        varchar(20) default 'text'    not null comment 'コンテンツ種別',
  txt_content text                          null comment 'テキストコンテンツ内容',
  movie_type  varchar(10) default 'youtube' not null comment '動画種別',
  movie_code  varchar(50)                   null comment '動画コード',
  img_caption varchar(100)                  null comment '画像キャプション'
)
  comment '活動報告詳細のコンテンツ' collate = utf8_unicode_ci;

create table reports
(
  id              int auto_increment
    primary key,
  project_id      int                  not null comment 'プロジェクトID',
  open            tinyint(1) default 0 not null comment '公開ステータス',
  title           varchar(200)         not null comment 'タイトル',
  created         datetime             not null comment 'データ作成日時',
  modified        datetime             not null comment 'データ更新日時',
  first_open_flag tinyint(1) default 0 not null
)
  comment '活動報告' collate = utf8_unicode_ci;

create table schema_migrations
(
  id      int auto_increment
    primary key,
  class   varchar(255) not null,
  type    varchar(50)  not null,
  created datetime     not null
);

create table settings
(
  id                        int(1) auto_increment
    primary key,
  user_id                   int(10)                      not null comment 'ユーザID',
  stripe_key                varchar(255)                 null comment 'Stripe 公開可能キー',
  stripe_secret             varchar(255)                 null comment 'Stripe シークレットキー',
  stripe_test_key           varchar(255)                 null comment 'Stripe 公開可能キー（テスト用）',
  stripe_test_secret        varchar(255)                 null comment 'Stripe シークレットキー（テスト用）',
  stripe_mode               tinyint(1)  default 0        not null comment 'Stripeの本番モード (1)or テストモード(0)',
  twitter_api_key           varchar(255)                 null comment 'Twitter API Key',
  twitter_api_secret        varchar(255)                 null comment 'Twitter API Secret',
  facebook_api_key          varchar(255)                 null comment 'Facebook API Key',
  facebook_api_secret       varchar(255)                 null comment 'Facebook API Secret',
  fee                       int(2)      default 20       not null comment 'サイト手数料',
  site_open                 tinyint(1)  default 0        not null comment 'サイト公開ステータス',
  site_name                 varchar(100)                 not null comment 'サイト名',
  site_title                varchar(255)                 null comment 'サイトタイトル',
  site_description          text                         null comment 'サイト紹介文',
  site_keywords             varchar(255)                 null comment 'メタキーワード',
  about                     text                         null comment 'Aboutページの表示文章',
  company_name              varchar(100)                 null comment '会社名（団体名）',
  company_type              int(1)      default 1        not null comment '法人or個人',
  company_url               varchar(255)                 null comment '会社URL',
  company_ceo               varchar(50)                  null comment '会社代表者名',
  company_address           varchar(255)                 null comment '会社住所',
  company_tel               varchar(30)                  null comment '会社電話番号',
  copy_right                varchar(50)                  null comment 'コピーライト表示内容',
  from_mail_address         varchar(255)                 null comment '送信先メールアドレス',
  admin_mail_address        varchar(255)                 null comment '管理者通知メールアドレス',
  mail_signature            text                         not null comment 'メール署名',
  toppage_projects_ids      varchar(150)                 null comment 'オススメプロジェクト',
  toppage_pickup_project_id int(10)                      null comment 'ピックアッププロジェクト',
  toppage_new_projects_flag tinyint(1)  default 0        not null comment '新着プロジェクト',
  toppage_ok_projects_flag  tinyint(1)  default 0        not null comment '達成したプロジェクト',
  link_color                varchar(6)  default '006699' null comment 'リンクの文字色',
  back1                     varchar(6)  default 'f2f2f2' not null comment '背景１の色',
  back2                     varchar(6)  default 'd2d2d2' not null comment '背景２の色',
  border_color              varchar(6)  default '999999' not null comment '枠線の色',
  top_back                  varchar(6)  default 'ffffff' null comment 'トップの背景色',
  top_color                 varchar(6)  default '000000' null comment 'トップの文字色',
  top_alpha                 int(2)      default 80       not null comment 'トップの透明度',
  footer_back               varchar(6)  default 'd5d5d5' null comment 'フッターの背景色',
  footer_color              varchar(6)  default '353539' null comment 'フッターの文字色',
  graph_back                varchar(6)  default '0099cc' null comment '達成率グラフの背景色',
  top_box_back              varchar(6)  default 'cceeff' not null comment 'トップ上段の背景色',
  top_box_black             int(2)      default 60       not null comment 'トップ上段の黒の透明度',
  top_box_color             varchar(6)  default '000000' not null comment 'トップ上段の文字色',
  top_box_height            int(3)      default 500      not null comment 'トップ上段の高さ',
  top_box_content_num       int(1)      default 1        not null comment 'トップ上段のコンテンツ数',
  content_type1             varchar(10)                  null comment 'コンテンツ１の種別',
  content_position1         varchar(2)                   null comment 'コンテンツ１の位置',
  txt_content1              text                         null comment 'コンテンツ１のテキスト内容',
  movie_type1               varchar(10)                  null comment 'コンテンツ１の動画種別',
  movie_code1               varchar(50)                  null comment 'コンテンツ１の動画コード',
  content_type2             varchar(10)                  null comment 'コンテンツ２の種別',
  content_position2         varchar(2)                   null comment 'コンテンツ２の位置',
  txt_content2              text                         null comment 'コンテンツ２のテキスト内容',
  movie_type2               varchar(10)                  null comment 'コンテンツ２の動画種別',
  movie_code2               varchar(50)                  null comment 'コンテンツ２の動画コード',
  cat_type_num              int(1)      default 1        not null comment '利用するカテゴリ種類数',
  cat1_name                 varchar(15) default 'カテゴリー'  not null comment 'カテゴリ１の表示名',
  cat2_name                 varchar(15) default 'エリア'    not null comment 'カテゴリ２（エリア）の表示名',
  google_analytics          varchar(500)                 null comment 'Google Analytics code'
)
  comment '各種設定データ' collate = utf8_unicode_ci;

create table users
(
  id               int auto_increment
    primary key,
  nick_name        varchar(100)                not null comment 'ニックネーム',
  name             varchar(100)                null comment '氏名',
  email            varchar(255)                not null comment 'メールアドレス',
  password         varchar(50)                 not null comment 'パスワード',
  sex              varchar(10)                 null comment '性別',
  address          varchar(30)                 null comment 'お住まい',
  birthday         date                        null comment '生年月日',
  birth_area       varchar(4)                  null,
  school           varchar(100)                null,
  twitter_id       varchar(255)                null comment 'twitter ID',
  facebook_id      varchar(255)                null comment 'Facebook ID',
  self_description text                        null comment '自己紹介',
  url1             varchar(200)                null comment 'URL1',
  url2             varchar(200)                null comment 'URL2',
  url3             varchar(200) charset latin1 null comment 'URL3',
  receive_address  text                        null comment 'リターン受け取り先住所',
  created          datetime                    null comment 'データ作成日時',
  modified         datetime                    null comment 'データ更新日時',
  group_id         int                         null comment 'ユーザ権限',
  active           tinyint(1) default 1        not null comment '退会してないフラグ',
  token            varchar(512)                null comment 'トークン',
  login_try_count  int(2)     default 0        not null comment 'ログイン試行回数'
)
  comment 'ユーザ' collate = utf8_unicode_ci;


