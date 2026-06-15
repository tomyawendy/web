# Planet Aviation Release Acceptance Checklist / 上线验收清单

Use this checklist after code deployment and database patch import.

代码部署和数据库补丁导入后，请按照本清单逐项验收。

## 1. Database / 数据库

- Import `database/patches/2026_06_14_cms_operations.sql` once.
- Import `database/patches/2026_06_14_spanish_frontend.sql` once after the CMS operations patch.
- Confirm patches are not imported twice.
- Confirm Chinese frontend/CMS content rows are removed.
- Confirm English and Spanish settings exist.
- Confirm existing pages, services, posts, media, contacts, admins, and settings are still present.

中文验收：

- 导入一次 `database/patches/2026_06_14_cms_operations.sql`。
- 在 CMS 运营补丁之后，导入一次 `database/patches/2026_06_14_spanish_frontend.sql`。
- 确认补丁没有重复导入。
- 确认前台和后台内容数据中不再保留中文语言行。
- 确认英文和西语设置数据存在。
- 确认原有页面、服务、文章、公文、媒体、联系表单、管理员和设置数据仍然存在。

## 2. Public Frontend / 前台官网

- Home opens normally and approved visual alignment is unchanged.
- Header links open: Home, Who We Are, Our Services, Insights, Documents, Contact.
- Service list and service detail pages open.
- Insights list and detail pages open.
- Documents list and detail pages open.
- Document detail shows attachment description and download button when an attachment exists.
- Contact form submits and creates a backend lead.
- Newsletter form submits and creates or reactivates a subscriber.
- Page source contains SEO title, description, keywords, and Open Graph tags when fields are filled.
- Default language is English.
- Spanish appears only after manual language switch.
- Spanish pages do not show Chinese content.

中文验收：

- 首页正常打开，并且已确认的视觉效果没有被破坏。
- 顶部导航可打开：Home、Who We Are、Our Services、Insights、Documents、Contact。
- 服务列表页和服务详情页可打开。
- Insights 列表页和详情页可打开。
- Documents 列表页和详情页可打开。
- 公文详情页在有附件时显示附件说明和下载按钮。
- 联系表单提交后，后台能看到联系线索。
- Newsletter 提交后，后台能看到订阅记录，或重新激活已取消订阅邮箱。
- 页面源码能看到 SEO title、description、keywords 和 Open Graph 标签。
- 默认语言为英文。
- 西语只在用户手动切换后显示。
- 西语页面不显示中文内容。

## 3. CMS / 后台 CMS

- Admin can log in, log out, and change password.
- Dashboard shows counts, recent logs, and CMS operating rules.
- Side menu contains Dashboard, Home Page, Pages, Services, Insights, Documents, Banners, Media Library, Contact Leads, Site Settings, SEO Settings, Admins / Roles, and Operation Logs.
- Home Page / Site Settings can save English and Spanish fields.
- SEO Settings can save site-level SEO and homepage SEO.
- Pages can edit About and Contact with SEO fields.
- Services can be created, edited, sorted, published, and taken offline.
- Insights can be searched, filtered, edited, published, archived, deleted in bulk, and shown on frontend.
- Documents can be searched, filtered, edited, published, archived, deleted in bulk, and downloaded from frontend.
- Media can upload images/documents, store alt text, preview images, copy paths, and delete unused uploaded files.
- Contact Leads can be marked New, In progress, Done, with notes and CSV export.
- Newsletter Subscribers can be exported, activated, and unsubscribed.
- Admin accounts can be created, edited, disabled, assigned roles, and optionally reset password.
- Operation Logs record login, logout, saves, uploads, status changes, deletes, and account actions.

中文验收：

- 管理员可以登录、退出和修改密码。
- Dashboard 显示统计、最近日志和 CMS 运营规则。
- 侧边栏包含 Dashboard、Home Page、Pages、Services、Insights、Documents、Banners、Media Library、Contact Leads、Site Settings、SEO Settings、Admins / Roles、Operation Logs。
- Home Page / Site Settings 可保存英文和西语字段。
- SEO Settings 可保存站点级 SEO 和首页 SEO。
- Pages 可编辑 About 和 Contact，并维护 SEO 字段。
- Services 可新增、编辑、排序、发布和下线。
- Insights 可搜索、筛选、编辑、发布、归档、批量删除，并在前台显示。
- Documents 可搜索、筛选、编辑、发布、归档、批量删除，并在前台下载附件。
- Media 可上传图片/文档、保存 alt 文案、预览图片、复制路径和删除不用的上传文件。
- Contact Leads 可标记 New、In progress、Done，填写备注并导出 CSV。
- Newsletter Subscribers 可导出、激活和取消订阅。
- Admin accounts 可新增、编辑、停用、分配角色和选择性重置密码。
- Operation Logs 能记录登录、退出、保存、上传、状态修改、删除和账号操作。

## 4. Deployment / 部署

- GitHub Actions deploy finishes successfully.
- `assets/uploads/**` is not deleted or overwritten by deployment.
- Production `config/database.php` is generated from GitHub Secrets.
- No PHP 500 error appears on Home, About, Services, Insights, Documents, Contact, or Backstage.
- Uploaded files can be accessed from public URLs.
- Source code, database export, and `assets/uploads/` backup are saved according to `deployment/source-backup-and-handover.md`.

中文验收：

- GitHub Actions 部署成功完成。
- `assets/uploads/**` 不会被部署覆盖或删除。
- 生产环境 `config/database.php` 由 GitHub Secrets 生成。
- Home、About、Services、Insights、Documents、Contact 和后台不出现 PHP 500 错误。
- 上传文件可以通过公开 URL 正常访问。
- 源码、数据库导出和 `assets/uploads/` 已按 `deployment/source-backup-and-handover.md` 备份。
