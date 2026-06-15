# Planet Aviation Delivery Summary / Planet Aviation 交付总结

## English

### Scope

This project delivers a `PHP + MySQL` corporate website with a public frontend and a CMS backend. The public frontend keeps the approved Figma visual direction. The CMS focuses on practical website operations: pages, services, insights, documents, media, contact leads, newsletter subscribers, SEO, administrators, roles, and operation logs.

### Language Policy

- The default public language is English.
- Spanish is available only after manual language switching.
- Chinese is not shown in the public website or CMS editing flow for this phase.
- The CMS interface remains English.
- Delivery documents are provided in English and Chinese for handover.

### Key Deliverables

- Public frontend pages and navigation.
- CMS for pages, services, insights, documents, categories, media, leads, newsletter, settings, administrators, and logs.
- Database patches for CMS operation fields and Spanish frontend content.
- GitHub Actions and InfinityFree deployment guide.
- CMS operation manual.
- Release acceptance checklist.
- Source code, database, and upload-files backup guide.

### Deployment Notes

1. Deploy the latest source code through GitHub Actions.
2. Import `database/patches/2026_06_14_cms_operations.sql` once if the live database does not already include the new CMS fields.
3. Import `database/patches/2026_06_14_spanish_frontend.sql` once after the CMS operations patch.
4. Complete `deployment/release-acceptance-checklist.md`.

## 中文

### 交付范围

本项目交付一套 `PHP + MySQL` 企业官网系统，包含前台官网和后台 CMS。前台保持已经确认的 Figma 视觉方向，不再随意破坏首页视觉。后台重点服务官网日常运营，包括页面、服务、新闻、公文、媒体、联系线索、Newsletter 订阅、SEO、管理员、角色权限和操作日志。

### 语言策略

- 前台默认语言为英文。
- 西语通过用户手动切换后显示。
- 当前阶段前台和后台编辑流程不显示中文内容字段。
- 后台操作界面暂时保持英文。
- 交付文档提供英文和中文版本，方便后续维护和交接。

### 主要交付物

- 官网前台页面和导航。
- 后台 CMS：页面、服务、Insights、Documents、分类、媒体库、联系线索、Newsletter、站点设置、管理员和日志。
- CMS 运营字段数据库补丁和西语前台内容补丁。
- GitHub Actions + InfinityFree 部署说明。
- 后台操作手册。
- 上线验收清单。
- 源码、数据库和上传文件备份说明。

### 部署说明

1. 通过 GitHub Actions 部署最新源码。
2. 如果线上数据库还没有新的 CMS 字段，导入一次 `database/patches/2026_06_14_cms_operations.sql`。
3. 在 CMS 运营补丁之后，再导入一次 `database/patches/2026_06_14_spanish_frontend.sql`。
4. 按照 `deployment/release-acceptance-checklist.md` 做线上验收。
