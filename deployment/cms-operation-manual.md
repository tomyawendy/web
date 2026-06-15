# Planet Aviation CMS Operation Manual / 后台操作手册

## English

### 1. Language Policy

- The public website opens in English by default.
- Spanish appears only after the visitor manually switches language.
- The CMS editing flow uses English and Spanish fields only.
- The CMS interface itself remains English.
- If a Spanish setting is empty, the public site falls back to English.

### 2. Main Menu

- `Dashboard`: content counts, recent activity, password change, and CMS operating notes.
- `Home Page`: homepage text, buttons, lookup labels, homepage SEO, and Figma-locked section notes.
- `Pages`: About, Contact, and reusable content pages.
- `Services`: service list and service details.
- `Insights`: news and article content.
- `Documents`: official documents, announcements, and downloadable files.
- `Banners`: hero banner image, title, subtitle, button text, and link.
- `Media Library`: upload, preview, copy paths, and delete unused uploaded files.
- `Contact Leads`: public contact form submissions, status, notes, and CSV export.
- `Newsletter Subscribers`: newsletter emails, status, and CSV export.
- `Site Settings`: navigation, footer, contact, newsletter, labels, and messages.
- `SEO Settings`: default SEO and homepage SEO.
- `Admins / Roles`: administrator accounts and roles.
- `Operation Logs`: login, save, upload, status change, delete, and account activity.

### 3. Home Page And Site Settings

1. Open `Home Page` or `Site Settings`.
2. Edit English fields first.
3. Fill Spanish fields when Spanish content is ready.
4. Keep Figma-locked visual areas stable unless a new screenshot comparison pass is planned.
5. Use `SEO Settings` for default meta title, keywords, description, and share images.

### 4. Pages

1. Open `Pages`.
2. Edit About or Contact pages.
3. Fill title, excerpt, content, SEO title, SEO keywords, SEO description, and SEO image.
4. Set status to `Published` when the page should appear on the public site.

### 5. Services

1. Open `Services`.
2. Create or edit a service card.
3. Fill title, summary, content, cover image path, sort order, status, and SEO fields.
4. Published services appear on the services page and homepage service section.

### 6. Insights

1. Open `Insights`.
2. Use search, status, and category filters.
3. Create or edit an Insight.
4. Fill title, excerpt, content, cover image, published date, pinned, featured, status, and SEO fields.
5. Use bulk actions to publish, take offline, archive, or delete selected records.

### 7. Documents

1. Open `Documents`.
2. Create or edit a document record.
3. Add title, excerpt, content, category, cover image, attachment, attachment description, published date, status, and SEO.
4. Supported attachments include PDF, Word, Excel, PowerPoint, and images.
5. Published documents appear on the Documents page and can show a download button.
6. Use bulk actions for publish, offline, archive, or delete.

### 8. Media Library

1. Open `Media Library`.
2. Choose `Images` or `Documents`.
3. Upload the file and add alt text or internal description.
4. Copy the generated path into page, service, insight, document, banner, or setting fields.
5. Use `Delete` only after confirming the file is no longer used.

Upload limits:

- Images: 5 MB.
- Documents: 10 MB.

### 9. Contact Leads And Newsletter

- Contact Leads can be marked as `New`, `In progress`, or `Done`.
- Contact Leads support internal notes and CSV export.
- Newsletter subscribers can be exported, activated, or unsubscribed.

### 10. Admins And Logs

- Create accounts only for trusted operators.
- Use Super Admin, Content Manager, and Editor roles.
- Disable accounts that should no longer access the CMS.
- Operation Logs should be checked after publishing, uploading, deleting, and account changes.

### 11. Database Patches

Import these SQL files once, in this order:

```text
database/patches/2026_06_14_cms_operations.sql
database/patches/2026_06_14_spanish_frontend.sql
```

Do not import the same patch twice. If phpMyAdmin reports an existing column, stop and confirm whether the patch was already applied.

## 中文

### 1. 语言策略

- 前台默认打开英文。
- 西语只在访客手动切换后显示。
- 后台内容编辑只保留英文和西语字段。
- 后台操作界面暂时保持英文。
- 如果某个西语字段为空，前台会使用英文兜底，避免页面空白。

### 2. 后台主菜单

- `Dashboard`：查看内容数量、最近操作、修改密码和 CMS 运营提示。
- `Home Page`：管理首页文字、按钮、查询标签、首页 SEO，以及 Figma 锁定区域提示。
- `Pages`：管理 About、Contact 和通用内容页。
- `Services`：管理服务列表和服务详情。
- `Insights`：管理新闻和文章内容。
- `Documents`：管理公文、公告和可下载文件。
- `Banners`：管理首屏 Banner 图片、标题、副标题、按钮和链接。
- `Media Library`：上传、预览、复制路径，以及删除不用的上传文件。
- `Contact Leads`：查看联系表单提交、处理状态、备注和 CSV 导出。
- `Newsletter Subscribers`：查看订阅邮箱、状态和 CSV 导出。
- `Site Settings`：管理导航、页脚、联系信息、Newsletter、标签和提示语。
- `SEO Settings`：管理站点默认 SEO 和首页 SEO。
- `Admins / Roles`：管理后台账号和角色。
- `Operation Logs`：查看登录、保存、上传、状态修改、删除和账号操作记录。

### 3. 首页和站点设置

1. 打开 `Home Page` 或 `Site Settings`。
2. 优先维护英文内容。
3. 西语内容准备好后再填写西语字段。
4. Figma 锁定视觉区域不要随意替换，除非重新做截图比对。
5. 在 `SEO Settings` 中维护默认 meta 标题、关键词、描述和分享图。

### 4. 页面管理

1. 打开 `Pages`。
2. 编辑 About 或 Contact 页面。
3. 填写标题、摘要、正文、SEO 标题、SEO 关键词、SEO 描述和 SEO 图片。
4. 页面需要上线时，把状态设置为 `Published`。

### 5. 服务管理

1. 打开 `Services`。
2. 新建或编辑服务卡片。
3. 填写标题、简介、正文、封面图路径、排序、状态和 SEO 字段。
4. 已发布服务会显示在服务页面和首页服务区。

### 6. 新闻 / Insights

1. 打开 `Insights`。
2. 使用搜索、状态和分类筛选内容。
3. 新建或编辑新闻。
4. 填写标题、摘要、正文、封面图、发布时间、置顶、推荐、状态和 SEO 字段。
5. 可以批量发布、下线、归档或删除所选记录。

### 7. 公文 / Documents

1. 打开 `Documents`。
2. 新建或编辑公文记录。
3. 填写标题、摘要、正文、分类、封面图、附件、附件说明、发布时间、状态和 SEO。
4. 附件支持 PDF、Word、Excel、PowerPoint 和图片。
5. 已发布公文会显示在 Documents 页面，并可显示下载按钮。
6. 可以批量发布、下线、归档或删除。

### 8. 媒体库

1. 打开 `Media Library`。
2. 选择 `Images` 或 `Documents`。
3. 上传文件，并填写 alt 文案或内部说明。
4. 把生成的路径复制到页面、服务、新闻、公文、Banner 或设置字段里。
5. 只有确认文件不再被使用时，才点击 `Delete` 删除。

上传限制：

- 图片：5 MB。
- 文档：10 MB。

### 9. 联系线索和订阅

- Contact Leads 可标记为 `New`、`In progress` 或 `Done`。
- Contact Leads 支持内部备注和 CSV 导出。
- Newsletter 订阅可以导出、重新激活或取消订阅。

### 10. 管理员和日志

- 只给可信人员创建后台账号。
- 使用 Super Admin、Content Manager、Editor 三类角色。
- 不再使用的账号应设置为停用。
- 发布、上传、删除、账号变更后，应查看 Operation Logs 确认记录。

### 11. 数据库补丁

按下面顺序各导入一次：

```text
database/patches/2026_06_14_cms_operations.sql
database/patches/2026_06_14_spanish_frontend.sql
```

不要重复导入同一个补丁。如果 phpMyAdmin 提示字段已存在，请先停止并确认该补丁是否已经导入过。
