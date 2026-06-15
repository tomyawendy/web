# Planet Aviation Source Backup And Handover

Use this document when handing over or backing up the website.

中文说明：本文档用于网站交付、备份和后期维护，覆盖源码、数据库、上传文件和部署包的备份方式。

## Source Code Backup

The authoritative source code should be kept in the GitHub repository.

Backup options:

- Download the repository as a ZIP from GitHub.
- Keep a tagged release after each approved deployment.
- Keep the `deployment/` folder because it contains deployment, CMS, database patch, and acceptance documents.

Do not treat the InfinityFree `htdocs` folder as the only source backup. It is a deployed copy, not the safest long-term source of truth.

## 源码备份

权威源码应保存在 GitHub 仓库中。

备份方式：

- 从 GitHub 下载仓库 ZIP。
- 每次确认上线后保留一个 release 或版本标签。
- 保留 `deployment/` 文件夹，因为其中包含部署、CMS、数据库补丁和验收文档。

不要把 InfinityFree 的 `htdocs` 目录当作唯一源码备份，它只是部署后的副本，不是最安全的长期源码来源。

## Database Backup

Before importing any database patch:

1. Open InfinityFree / phpMyAdmin.
2. Select the project database.
3. Export all tables as SQL.
4. Save the export with a date, for example:

```text
planet_aviation_backup_2026_06_14.sql
```

After patch import:

1. Confirm pages, services, posts, media, contact submissions, newsletter subscriptions, admins, settings, and logs still exist.
2. Keep both the pre-patch backup and the post-patch export.

## 数据库备份

导入任何数据库补丁前：

1. 打开 InfinityFree / phpMyAdmin。
2. 选择项目数据库。
3. 将全部表导出为 SQL。
4. 用日期命名保存，例如：

```text
planet_aviation_backup_2026_06_14.sql
```

补丁导入后：

1. 确认 pages、services、posts、media、contact submissions、newsletter subscriptions、admins、settings 和 logs 仍然存在。
2. 同时保留补丁前备份和补丁后导出。

## Uploads Backup

CMS-uploaded files live under:

```text
assets/uploads/
```

The GitHub Actions deployment excludes this folder so uploads are not overwritten.

Backup this folder from FTP before major releases, especially when the team has uploaded new media or documents through the CMS.

## 上传文件备份

后台上传的文件位于：

```text
assets/uploads/
```

GitHub Actions 部署会排除此文件夹，因此不会覆盖后台上传的素材。

重大上线前，请通过 FTP 备份该文件夹，尤其是团队已经通过后台上传了新图片或文档时。

## Deployment Package

GitHub Actions syncs source folders into:

```text
outputs/infinityfree-htdocs-package/htdocs/
```

Then it uploads that package to InfinityFree `htdocs/`.

The workflow writes production database credentials from GitHub Secrets, so database passwords should not be committed into the repository.

## 部署包

GitHub Actions 会先把源码同步到：

```text
outputs/infinityfree-htdocs-package/htdocs/
```

然后上传到 InfinityFree 的 `htdocs/`。

生产数据库配置由 GitHub Secrets 写入，因此数据库密码不应提交到仓库。

## Handover Checklist

- GitHub repository access confirmed.
- InfinityFree panel access confirmed.
- phpMyAdmin access confirmed.
- FTP credentials stored securely by the owner.
- GitHub Secrets configured for FTP and database.
- Latest database patch imported once.
- Latest source ZIP or GitHub release saved.
- `assets/uploads/` backed up from FTP.
- CMS operation manual shared with editors.
- Release acceptance checklist completed after deployment.

## 交接清单

- GitHub 仓库权限已确认。
- InfinityFree 面板权限已确认。
- phpMyAdmin 权限已确认。
- FTP 凭据由负责人安全保存。
- GitHub Secrets 已配置 FTP 和数据库信息。
- 最新数据库补丁已导入一次。
- 最新源码 ZIP 或 GitHub release 已保存。
- `assets/uploads/` 已通过 FTP 备份。
- CMS 操作手册已交给编辑人员。
- 部署后已完成上线验收清单。
